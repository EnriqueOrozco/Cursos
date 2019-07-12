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
				<a href="configuration-password.php"><button class="button_on">Cambiar contraseña</button></a>
				<a href="configuration-apk.php"><button class="button_off">Aplicacion</button></a>
			</div>
			
			<form action="" method="post">
				
				<?php 

					if (isset($_POST['editar'])) {
						require "class/db.php";

						$passActual = $mysqli->real_escape_string($_POST['passActual']);
						$pass1 = $mysqli->real_escape_string($_POST['pass1']);
						$pass2 = $mysqli->real_escape_string($_POST['pass2']);

						$passActual = md5($passActual);
						$pass1 = md5($pass1);
						$pass2 = md5($pass2);

						$sqlA = $mysqli->query("SELECT password FROM data WHERE id = '".$_SESSION['id']."'");
						$rowA = $sqlA->fetch_array();

						if ($rowA['password'] == $passActual) {
							
							if ($pass1 == $pass2) {
								
								$update = $mysqli->query("UPDATE data SET password = '$pass1' WHERE id = '".$_SESSION['id']."'");
								if($update) {echo "<center> Se ha actualizado tu contraseña </center>";}
							}
							else{
								echo "<center> Las dos contraseñas no coinciden </center>";
							}
						}
						else{
							echo "<center> Tu contraseña actual no coinciden </center>";
						}

					}

				?>

				<div class="sub-content-edit">
					<div class="content-of-edit">
						<div class="content-titles">Contraseña actual</div>
						<div class="content-input"><input type="password" name="passActual" autocomplete="off" required></div>
					</div>
					<div class="content-of-edit">
						<div class="content-titles">Contraseña nuevas</div>
						<div class="content-input"><input type="password" name="pass1" autocomplete="off" required></div>
						<div style="color:red; font-size: 12px;"><?php if(isset($existe)) {echo $existe;}?></div>
					</div>
					<div class="content-of-edit">
						<div class="content-titles">Escribe otra vez tu contraseña</div>
						<div class="content-input"><input type="password" name="pass2" autocomplete="off" required></div>
					</div>
					<div class="content-of-edit">
						<div class="content-titles"></div>
						<div class="content-button">
							<input type="submit" class="save" name="editar" value="Cambiar contraseña">
						</div>
					</div>
				</div>

			</form>
			
		</div>
	</div>
	

</body>
</html>