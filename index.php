<?php
	session_start();

	require("includes.php");

	//Get the path
	$path = Path::from_path_info();

	if(is_loggedin()) {
	    $u = NXAuth::user();
	}

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
            $controller->pre_route($path->args());
            $content = $controller->route($path->args());
        } catch(HTTPRedirect $e) {
            if(isset($flash)) {
                $_SESSION['flash'] = serialize($flash);
            }

            header("Location: {$e->url}");
            exit();
	} catch (HTTPError $e){ 
	    $error = "<h3> {$e->title()} </h3> <p> {$e->message()} </p>";
	} catch(Exception $e){
	    $error =  "<h3> Error </h3> <p> {$e->getMessage()} </p>";
	}

        $menu = new DatabaseMenu;
        $menu->AddItemAtOrder('/main', 'Nyheter', 1);
        $menu->AddItemAtOrder('/timetable', 'Schema', 2);

	//Add admin check right here !
	if(is_admin()) {
	    $menu->AddItem("/admin", "Admin");
	}
?>
<!DOCTYPE html>
<html lang="sv">
	<head>
            <title> NitroXy <?=$event?> - Info </title>
            <meta http-equiv="content-type" content="text/html; charset=utf-8"/>

            <!-- Use jquery -->
            <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
            <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
            <script src="/scripts/jquery-ui.min.js"></script> 

            <!-- Include bootstrap ... -->
            <!-- Latest compiled and minified CSS -->
            <!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">-->
            <link rel="stylesheet" href="http://bootswatch.com/united/bootstrap.min.css">

            <!-- Optional theme -->
            <!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css">-->

            <!-- Latest compiled and minified JavaScript -->
            <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

            <!-- Our custom scripts .. -->
            <script src="/scripts/image.js"></script>
            <script src="/scripts/preview.js"></script>
            
            <script>
                $(document).ready(function() {
                    $('.dropdown-toggle').dropdown();
                }
            </script>

            <!-- Our complementary stylesheet -->
            <link rel="stylesheet" type="text/css" href="/style.css"/>
	</head>
	<body style="width: 1000px; margin: auto;">
            <header id="header">
                <h1> NitroXy <?=$event?> Info 
                <small> Nå information snabbt och enkelt </small> </h1>
                <div id="navigation_menu">
                    <?  
                        if(count($path->raw_parts()) > 0) {   
                            echo $menu->render($path->raw_parts()[0]);
                        } else {
                            echo $menu->render('');
                        }
                    ?>
                </div>
            </header>

            <div id="content">
            <?php
                if(isset($error)) {
                    echo $error;
                } else {
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
                    echo $content;
                }
            ?>
                <div style="display:none;" class="panel panel-default" id="holder"></div>
            </div>
            <div id="footer">
            <hr>
            <p class="madeby"> Sidan är gjord utav <a href="http://cpluss.se">cpluss</a> för NitroXy </p>

            <div id="login_menu">
                    <? if(is_loggedin()) { ?>
                    <p> Inloggad som <?=$u->username?>, <a href="/user/logout"> logga ut </a> </p>
                    <? } else { ?>
                    <p> <a class="btn btn-default" href="/user/login"> Logga In </a> </p>
                    <? } ?>
            </div>
            </div>
	</body>
</html>
