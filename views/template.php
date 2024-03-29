<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="icon" type="image/png" href="../favicon.png" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
	<link href="../css/responsive.css" rel="stylesheet">
	<script type="text/javascript" src="../js/script.js"></script>
	<title><?= $t ?></title>
</head>
<body>
	<div id="nav">
		<div class="container">
			<div class="logo">
				<i class="fab fa-instagram fa-lg"></i>
				<div class="separator"></div>			
				<a href="/">Camagru</a>
			</div>
			<div class="search-cont">
				<div class="search">
					<i class="fas fa-search fa-xs"></i>
					<input id="search-box" type="text" placeholder="Rechercher" onkeyup="searchAccount()"/>
					<div id="corner"></div>
					<div id="search-results"></div>
				</div>
			</div>
			<div class="user">
				<a href="/camagru">
					<i class="fas fa-camera-retro fa-lg"></i>
				</a>
				<a href="/account">
					<i class="far fa-user fa-lg"></i>
				</a>
				<a href="/logout">
					<i class="fas fa-sign-out-alt fa-lg"></i>
				</a>
			</div>
		</div>
	</div>
	<div id="content">
		<?= $content ?>
	</div>
	<div id="footer">
	<p>Made with ❤️ by <a href="https://guillaumerx.fr" target="_blank">guroux</a></p>
	</div>
</body>
</html>