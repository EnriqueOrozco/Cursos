<?php 
ob_start();
?>
<?php 
	session_start();
	if (isset($_SESSION['logueado']) && $_SESSION['logueado'] == TRUE) {
		header("location: home.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Curso</title>
	<link rel="stylesheet" href="css/estilo.css">
</head>
<body>
	
	<div id="wrapper">
		
		<?php  

			if (isset($_POST['registro'])) {
				
				require ("class/db.php");

				$email = $mysqli->real_escape_string($_POST['mail']);
				$nombre = $mysqli->real_escape_string($_POST['nombre']);
				$usuario = $mysqli->real_escape_string($_POST['usuario']);
				$password = md5($_POST['password']);
				$ip = $_SERVER['REMOTE_ADDR'];

				$consultarusuario = "SELECT username FROM data WHERE username = '$usuario'";
				$consultaremail = "SELECT email FROM data WHERE email = '$email'";

				if ($resultadousuario = $mysqli->query($consultarusuario)) 
					$numerousuario = $resultadousuario->num_rows;
				
				if($resultadoemail = $mysqli->query($consultaremail));
				$numeroemail = $resultadoemail->num_rows;

				if ($numeroemail>0) {
					echo "<center><span class='sub-error'> Este correo ya esta registrado, intenta con otro </span></center>";
				}
				elseif ($numerousuario>0) {
					echo "<center><span class='sub-error'> Este usuario ya existe </span></center>";
				}
				else{

					$aleatorio = uniqid();

					$query = "INSERT INTO data (email,name,username,password,signup_date,last_ip,code) VALUES ('$email','$nombre','$usuario','$password',now(),'$ip','$aleatorio')";

					if ($registro = $mysqli->query($query)) {
						
						Header("Refresh: 2; URL=index.php");

						echo "<center><span class='sub-error'> Felicidades $usuario se ha registrado correctamente, te hemos enviado un correo de confirmación. </span></center>";

						$email_to = $email;
						$email_subject = "Confirma tu email Curso";
						$email_from = "replay.tusitioweb.com";

						$email_message = "Hola" .$usuario. ", para poder disfrutar de nuestro sitio web, debe confirmar tu emial\n\n";
						$email_message .= "Ingresa el siguiente codigo para confirmar tu email\n\n";
						$email_message .= "Codigo:" .$aleatorio. "\n";

						$headers = 'From:' .$email_from."\r\n".
						'Reply-to:' .$email_from. "\r\n".
						'X-Mailer: PHP/' . phpversion();
						@mail($email_to, $email_subject, $email_message, $headers);
					}
					else{
						echo "Ha ocurrido un error en el registro, intentelo de nuevo";
						header("Refresh: 2; URL=sign-up.php");
					}
				}

				$mysqli->close();

			}

		?>

		<div class="container">
			<div class="header">
				
			</div>
			<div class="login">
				<h2>Regístrarte</h2>
				<form action="" method="post">
					<input type="text" placeholder="Usuario" name="usuario" required />
					<input type="text" placeholder="Nombre completo" name="nombre" required />
					<input type="password" placeholder="Contraseña" name="password" required />	
					<input type="email" placeholder="Correo electrónico" name="mail" required />
					<input type="submit" value="Registrate" name="registro" />
				</form>
			</div>
		</div>
		
		<div class="sub-container">
			<div class="s-part">
				¿Tienes una cuentas? <a href="index.php">Entrar</a>
			</div>
		</div>

	</div>

</body>
</html>

<?php
ob_end_flush();
?>