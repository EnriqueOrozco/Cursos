<?php 
	ob_start();
?>
<?php
	session_start();
	if (isset($_SESSION['logueado']) && $_SESSION['logueado'] == TRUE)  {
	  	header("location: home.php");
	  }  
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="initial-scale=1.0, user-scalable=yes">
	<title>Curso</title>
	<link rel="stylesheet" href="css/estilo.css">
</head>
<body>

	<?php 
		if (isset($_POST['entrar'])) {
			require ("class/db.php");

			$username = $mysqli->real_escape_string($_POST['usuario']);
			$password = md5($_POST['password']);

			$consulta = "SELECT username,password,id FROM data WHERE username = '$username' AND password = '$password'";

			if ($resultado = $mysqli->query($consulta)) {
				while ($row = $resultado->fetch_array()) {
					$userok = $row['username'];
					$passok = $row['password'];
					$id = $row['id'];
				}
				$resultado->close();
			}
			$mysqli->close();

			if (isset($username) && isset($password)) {
				if ($username == $userok && $password == $passok) {
					session_start();
					$_SESSION['logueado'] = TRUE;
					$_SESSION['username'] = $userok;
					$_SESSION['id'] = $id;
					header ("location: home.php");
				}else{
					header("location: index.php?error=login");
				}
			}
		}
	?>

	<div class="container">
		<div class="header">
			
		</div>
		<div class="login">
			<h2>Iniciar sesión</h2>
			<form action="" method="post">
				<input type="text" placeholder="Usuario" name="usuario" autocomplete="off"/>
				<input type="password" placeholder="Contraseña" name="password"/>
					<div class="error">
						<?php 
							if (isset($_GET['error'])) {
								echo "<center><span class='sub-error'>Error el usuario o contraseña no coinciden</span></center>";
							}
						?>
					</div>
				<input type="submit" value="Iniciar sesión" name="entrar" />
			</form>
		</div>
		<a href="recover.php">
			<div class="recover-password">
				<span>Olvide mi contraseña</span>
			</div>
		</a>
	</div>

	<div class="sub-container">
		<div class="s-part">
			¿No tienes una cuentas? <a href="sign-up.php">Regístrate</a>
		</div>
	</div>

</body>
</html>

<?php
ob_end_flush();
?>