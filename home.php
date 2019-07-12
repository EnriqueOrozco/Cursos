<?php  
	
	session_start();
	if (!isset($_SESSION['logueado']) && $_SESSION['logueado'] == FALSE) {
		header("location: index.php");
	}

	include "class/functions.php";

?>
<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>Curso</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/fonts.css">
	<script src="js/jquery-3.1.1.min.js"></script>
	<script src="js/main.js"></script>
	</head>
<body>

	<?php 

		require("class/db.php");

		$consultaA = "SELECT confirmed FROM data WHERE username = '".$_SESSION['username']."'";
		$resultadoA = $mysqli->query($consultaA);
		$row = $resultadoA->fetch_array();

		if ($row['confirmed'] == 0) {
			echo "<div class='top-confirm'><a href='code.php'> Confirma tu email aquí </a></div>";
		}

		$mysqli->close();
	?>
	
	<?php include "header.php" ?>

	<div class="content">
		<div class="content-right">
			
			<?php 

				require "class/db.php";

				$sqlA = $mysqli->query("SELECT * FROM publications ORDER BY id DESC");
					while ($rowA = $sqlA->fetch_array()) {
						$sqlB = $mysqli->query("SELECT * FROM data WHERE id = '".$rowA['user']."'");
							$rowB = $sqlB->fetch_array();
						$sqlC = $mysqli->query("SELECT * FROM archive WHERE publications = '".$rowA['id']."'");
							$rowC = $sqlC->fetch_array();
			?>
			
			<div class="sub-content-right">
				<div class="content-top-right">
					<div class="content-right-profile">
						<div class="content-picture"><a href="profile.php?username=<?php echo $rowB['username'];?>"><img width="50" height="50" src="<?php echo $rowB['avatar'];?>"></a></div>
					</div>
					<div class="content-right-user">
						<div class="content-right-name"><a href="profile.php?username=<?php echo $rowB['username'];?>"><?php echo $rowB['username'];?></a></div>
						<div class="content-location"><?php echo $rowA['location'];?></div>
					</div>	
				</div>
				<div class="content-public">
						<img src="archive/<?php echo $rowC['route'];?>" width="100%"  >
					</div>
				<div class="content-publications">
						<strong style="color: #262626;"><?php echo $rowB['username'];?></strong> <?php echo $rowA['descripcions']; ?>
				</div>
			</div>

			<?php } ?>

		</div>

		<div class="content-left">
			<div class="content-avatar">
				<a href="profile.php?username=<?php echo $_SESSION['username'];?>"><img src="<?php datos_usuarios($_SESSION['id'], 'avatar');?>" width="94" height="94"></a>
			</div>
			<div class="content-name">
				<div class="sub-content-name"><a href="profile.php?username=<?php echo $_SESSION['username'];?>"><?php echo $_SESSION['username']; ?></a></div>
			</div>
			<img src="imagenes/0.png" width="100%" height="100%" style="border-radius: 3px 3px 3px 3px; margin-bottom: 10px;">
		</div>
	
		<div class="content-link">
			<a href="go-up.php"><button class="go-up">Publicar</button></a>
			<a href="chat.php"><button class="go-up">Chat</button></a>
		</div>

		<div class="content-courses">
			<div class="content-headboard">
				<span>Cursos</span>
			</div>
			<div class="sub-content-courses">
				<a href="../../página de lavado de dinero/erik/admin/login.php"><button class="go-send">Lavado de dinero</button></a>
				<a href="../../cursos/index.php"><button class="go-send">Otro curso</button></a>
			</div>
		</div>

	</div>

</body>
</html>