<?php
	session_start();

	require("includes.php");

	//Get the path
	$path = Path::from_path_info();

	//Execute a controller
	function exec_controller($controller, $path) {
            //Run controller
            $controller->pre_route($path->args());
            $raw_content = $controller->route($path->args());

            return $raw_content;
	}

	$flash = array();
	if(isset($_SESSION['flash'])) {
	    $flash = unserialize($_SESSION['flash']);
	    unset($_SESSION['flash']);
	}
	
	try {
	    $controller = Controller::factory($path);
	} catch (HTTPError $e){ 
	    echo "<h2> {$e->title()} </h2> <p> {$e->message()} </p>";
	    die();
	} catch(Exception $e){
	    echo "<h2> Error </h2> <p> {$e->getMessage()} </p>";
	    die();
	}

	/*
	Build the menu, right now this is done manually,
	but that will _eventually_ change
	*/
	$menu = new Menu();
	$menu->AddItem("/main", "Schema");
	$menu->AddItem("/info", "Allmän information");
	$menu->AddItem("/esport", "E-Sport");
	$menu->AddItem("/kreativ", "Kreativ");
	$menu->AddItem("/kiosk", "Kiosk");
	$menu->AddItem("/activity", "Activity");

	//Add admin check right here !
	if(is_admin()) {
	    $menu->AddItem("/admin", "Admin");
	}
	if(is_loggedin()) {
	    $u = NXAuth::user();
	}

	$submenu = $controller->BuildSubMenu();
?>
<html>
	<head>
            <title> NitroXy <?=$event?> - Info </title>
            <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
            <link rel="stylesheet" type="text/css" href="/style.css"/>
	</head>
	<body>
	<div id="wrapper">
		<div id="header">
		<h1> NitroXy <?=$event?> - Info </h1>
		<?=$menu->render($path->raw_path());?>
		<div id="submenu">
			<?=$submenu->render($path->raw_path());?>
		</div>

		</div>
		<div id="content">
		<?php

			//Display the controller
			try {
                            $content =  exec_controller($controller, $path);

                            //Show flash messages
                            foreach($flash as $class => $msg) {
                                    if(is_array($msg)) {
                                        foreach($msg as $m) { 
                                            ?> <p class="<?=$class?>"> <?=$m?> </p> <?
                                        }
                                    } else {
                                        ?> <p class="<?=$class?>"> <?=$msg?> </p> <?
                                    }
                            }


                            //Show content
                            echo $content;
			} catch(HTTPRedirect $e){
                            //Set flash for next redirect
                            if(isset($flash)) {
                                $_SESSION['flash'] = serialize($flash);
                            }

                            header("Location: {$e->url}");
                            exit();
			} catch (HTTPError $e){ 
                            echo "<h2> {$e->title()} </h2> <p> {$e->message()} </p>";
			} catch(Exception $e){
                            echo "<h2> Error </h2> <p> {$e->getMessage()} </p>";
			}
		?>
		</div>
		<div id="footer">
		<hr>
		<p> Sidan är gjord utav cpluss för NitroXy </p>

		<div id="login_menu">
			<? if(is_loggedin()) { ?>
			<p> Inloggad som <?=$u->username?>, <a href="/user/logout"> logga ut </a> </p>
			<? } else { ?>
			<p> <a href="/user/login"> Logga In </a> </p>
			<? } ?>
		</div>
		</div>
	</div>
	</body>
</html>
