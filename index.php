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
	
	$controller = Controller::factory($path);

	//Build menu
	$menu = new Menu();
	$menu->AddItem("/main", "Startsida", "main");
	$menu->AddItem("/esport", "E-Sport", "esport");

	$submenu = $controller->BuildSubMenu();

?>
<html>
	<head>
		<title> cpluss </title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" type="text/css" href="/style.css"/>
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<h1> NitroXy 16 - Info </h1>
				<?=$menu->render($path->controller());?>
				<div id="submenu">
					<?=$submenu->render($path->controller());?>
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
				<p> Copyright &copy; NitroXy </p> 
			</div>
		</div>
	</body>
</html>
