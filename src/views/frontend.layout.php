<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>AJARCMS - Présentation</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/app.css">
</head>
<body>

<?php if (strtok($_SERVER['REQUEST_URI'], '/') != "admin"): ?>
<nav class="navbar">
	<div class="top"></div>
	<div class="container">
		<div class="brand">
			<img src="../img/white-logo.png" alt="">
		</div>
		<ul class="navlink">
			<li><a href="">Fonctionnalités</a></li>
			<li><a href="">Extensions</a></li>
			<li><a href="">Références</a></li>
		</ul>
		<div class="pull-right">
			<a class="btn btn-effect">
				<svg>
					<rect x="0" y="0" fill="none" width="100%" height="100%"/>
				</svg>
				Téléchargement
			</a>
		</div>
	</div>
</nav>
<?php endif; ?>



<div class="content grey-background">
	<?php include $this->view; ?>
</div>

<footer>

</footer>

</body>
</html>