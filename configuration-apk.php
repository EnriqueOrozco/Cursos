<?php  
	session_start();
	if (!isset($_SESSION['logueado']) && $_session['logueado'] == FALSE) {
		header ("location: index.php");
	}

	include "class/functions.php";

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Curso</title>
	<link rel="stylesheet" href="css/fonts.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="js/jquery-3.1.1.min.js"></script>
	<script src="js/main.js"></script>
</head>
<body>
	
	<?php include "header.php" ?>

	<div class="content">
		<div class="content-edit">

			<div class="sub-content-option">
				<a href="configuration.php"><button class="button_off">Editar perfil</button></a>
				<a href="configuration-password.php"><button class="button_off">Cambiar contraseña</button></a>
				<a href="configuration-apk.php"><button class="button_on">Aplicacion</button></a>
			</div>
				<div class="sub-content-edit">
					<div class="content-of-edit">
						<div class="content-titles">Aplicacion muy pronto..</div>
					</div>

				</div>

		</div>
	</div>
	

</body>
</html>