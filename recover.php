<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Curso</title>
	<link rel="stylesheet" href="css/estilo.css">
</head>
<body>

	<?php 
		if (isset($_POST['codigo'])) {
			require "class/db.php";

			$email = $mysqli->real_escape_string($_POST['email']);

			$sql = $mysqli->query("SELECT username,email FROM data WHERE email = '$email'");
			$row = $sql->fetch_array();
			$count = $sql->num_rows;

			if ($count == 1) {
				$token = uniqid();

				$act = $mysqli->query("UPDATE data SET token = '$token' WHERE email = '$email'");

				$email_to = $email;
	        	$email_subject = "Cambio de contrasena";
	        	$email_from = "reply.tusitioweb.com";

	        	$email_message = "Hola " . $row['username'] . ", haz solicitado cambiar tu contraseña, ingresa al siguiente link\n\n";
	        	$email_message .= "https://tuntoriales.000webhostapp.com/nuevacontrasena.php?user=".$row['username']."&token=".$token."\n\n";

		        $headers = 'From: '.$email_from."\r\n".
		        $headers ='Reply-To: '.$email_from."\r\n".
	    	    $headers ='X-Mailer: PHP/' . phpversion();
	        	@mail($email_to, $email_subject, $email_message, $headers);

	        	echo "<center><span class='sub-error'>Te hemos enviado un email para cambiar tu contraseña</center></span>";
			} else{
				echo "<center><span class='sub-error'>Este correo no esta registrado en nuestra base de datos</center></span>";
			}
		}
	?>

	<div class="container">
		<div class="header">
			
		</div>
		<div class="login">
			<h2>Restablecer contraseñ<a href=""></a></h2>
			<form action="" method="post">
				<input type="email" placeholder="Correo electronico" name="email" autocomplete="off" required />
				<input type="submit" value="Recuperar mi contraseña" name="codigo" />
			</form>
		</div>
	</div>

	<div class="sub-container">
		<div class="s-part">
			¿Quieres regresar? <a href="index.php">Regresar</a>
		</div>
	</div>


</body>
</html>
