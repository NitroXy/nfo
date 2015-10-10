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

		header("Location: {$root}{$e->url}");
		exit();
	} catch (HTTPError $e){
		$error = "<h3> {$e->title()} </h3> <p> {$e->message()} </p>";
	} catch(Exception $e){
		$error =	"<h3> Error </h3> <p> {$e->getMessage()} </p>";
	}

	$menu = new DatabaseMenu;
	//$menu->AddItemAtOrder('/main', 'Nyheter', 1);
	$menu->AddItemAtOrder('/timetable', 'Schema', 1);

	//Add admin check right here !
	if(is_admin()) {
		$menu->AddItem("/admin", "Admin");
	}
?>
<!DOCTYPE html>
<html lang="sv">
	<head>
		<title> NitroXy <?=$event?> - Info </title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script>
			var root = '<?=$root?>';
		</script>

		<!-- Use jquery -->
		<script src="//code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script src="<?=$root?>/scripts/jquery-ui.min.js"></script>

		<!-- Include bootstrap ... -->
		<!-- Latest compiled and minified CSS -->
		<!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">-->
		<link rel="stylesheet" href="//bootswatch.com/united/bootstrap.min.css">

		<!-- Optional theme -->
		<!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css">-->

		<!-- Latest compiled and minified JavaScript -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

		<!-- Our custom scripts .. -->
		<script src="<?=$root?>/scripts/image.js"></script>
		<script src="<?=$root?>/scripts/preview.js"></script>

		<script>
		$(function() {
			$('.dropdown-toggle').dropdown();
		});
		</script>

		<!-- Our complementary stylesheet -->
		<link rel="stylesheet" type="text/css" href="<?=$root?>/style.css"/>
	</head>
	<body>
		<header class="container">
			<h1>
				NitroXy <?=$event?> Info
				<small>Nå information snabbt och enkelt</small>
			</h1>
			<nav id="navigation_menu" class="navbar navbar-default">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
						Meny
						<div class="bar">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</div>
					</button>
				</div>
				<div class="collapse navbar-collapse" id="navbar">
					<?php
					if(count($path->raw_parts()) > 0) {
						$parts = $path->raw_parts();
						echo $menu->render($parts[0]);
					} else {
						echo $menu->render('');
					}
					?>
				</div>
			</nav>
		</header>

		<div id="content" class="container">
			<?php if ( isset($error) ): ?>
				<?=$error?>
			<?php else: ?>
				<?php foreach($flash as $class => $msg): ?>
					<?php if(is_array($msg)): ?>
						<?php foreach($msg as $m): ?>
							<p class="<?=$class?>"><?=$m?></p>
						<?php endforeach; ?>
					<?php else: ?>
						<p class="<?=$class?>"><?=$msg?></p>
					<?php endif; ?>
				<?php endforeach; ?>
				<?=$content;?>
			<?php endif; ?>

			<div style="display:none;" class="panel panel-default" id="holder"></div>
		</div>

		<footer class="container">
			<hr>
			<p class="madeby"> Sidan är gjord utav <a href="http://cpluss.se">cpluss</a> för NitroXy </p>

			<div id="login_menu">
				<?php if(is_loggedin()) { ?>
					<p> Inloggad som <?=$u->username?>, <a href="<?=$root?>/user/logout"> logga ut </a> </p>
				<?php } else { ?>
					<p> <a class="btn btn-default" href="<?=$root?>/user/login"> Logga In </a> </p>
				<?php } ?>
			</div>
		</footer>
	</body>
</html>
