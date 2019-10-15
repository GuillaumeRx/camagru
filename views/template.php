<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
	<title><?= $t ?></title>
</head>
<body>
	<div id="nav">
		<div class="logo">
			<a href="/">Camagru</a>
		</div>
		<div>
			<div class="search">
				<i class="fas fa-search fa-xs"></i>
				<input type="text" placeholder="Rechercher"/>
			</div>
		</div>
		<div class="user">
			<a href="#">
				<i class="far fa-user fa-lg"></i>
			</a>
		</div>
	</div>
	<?= $content ?>
</body>
</html>