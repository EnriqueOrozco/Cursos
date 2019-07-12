<?php 
	ob_start();
?>
 <?php 
 session_start();
 if (!isset($_SESSION['logueado']) && $_SESSION['logueado'] == FALSE) {
 	header("Location: index.php");
 }
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

	<div id="content">
		
		<?php 

			if (isset($_POST['codigo'])) {
				
				require ("class/db.php");

				$code = $mysqli->real_escape_string($_POST['code']);

				$consultausuario = "SELECT code FROM data WHERE username = '".$_SESSION['username']."'";
				$resultadousuario = $mysqli->query($consultausuario);
				$row = $resultadousuario->fetch_array();

				if ($row['code'] == $code) {
					
					header ("refresh: 2; URL=home.php");
					echo "<center><span class='sub-error'>Felicidades ya haz confirmado tu email</span></center>";

					$sql = $mysqli->query("UPDATE data SET confirmed = '1' WHERE username = '".$_SESSION['username']."'");
				}

				else{
					echo "<center><span class='sub-error'>El codigo no coincide</span></center>";
				}

				$mysqli->close();

			}

		?>

		 <div class="content-main">
		 	<div>
		 		
		 	</div>
		 	<form action="" method="post">
		 		<div class="">
		 			<input type="text" placeholder="Código de seguridad" name="code" autocomplete="off" required/>
		 			<input type="submit" value="Confirmar email" name="codigo">
		 		</div>
		 	</form>
		 </div>

	</div>
	
</body>
</html>

<?php 
	ob_end_flush();	
?>