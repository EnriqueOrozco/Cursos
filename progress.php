<?php 

	session_start();
	if (!isset($_SESSION['logueado']) && $_SESSION['logueado'] == FALSE) {
		header ("Location: index.php");
	}

	include "class/functions.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Curso</title>
	<link rel="stylesheet" href="css/fonts.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="js/jquery-3.1.1.min.js"></script>
	<script src="js/main.js"></script>
</head>
<body>
	
	<?php 

		if (isset($_GET['username'])) {
		
			require "class/db.php";

			$sqlA = $mysqli->query("SELECT * FROM data WHERE username = '".$_GET['username']."'");
			$rowA = $sqlA->fetch_array();

			$sqlB = $mysqli->query("SELECT * FROM progress WHERE username = '".$_GET['username']."'");
			$rowB = $sqlB->fetch_array();

	 ?>
	
	<?php include("header.php") ?>

<div class="content-profile">
	<div class="sub-content-profile">
		<div class="user">
			<div class="picture-for-user">
				<div class="picture">
					<img src="<?php echo $rowA['avatar'];?>" width="130" height="130">
				</div>
			</div>
			<div class="name-user">
				<div class="sub-name-user"><?php echo $rowA['username'];?></div>
				<div class=""><?php echo $rowA['type-user'];?></div>
				<div class=""><?php echo $rowA['biography'];?></div>
			</div>
		</div>
		<div class="courses-taken">
			<div class="courses">
				<a href="profile.php?username=<?php echo $rowA['username'];?>">
					<div class="button_off">
						<span class="sub-watch">Vista al perfil</span>
					</div>
				</a>
				<a href="progress.php?username=<?php echo $rowA['username'];?>">
					<div class="button_on">
						<span class="sub-progress">Progreso</span>
					</div>
				</a>
				</div>

				<div class="pop-up-window">
					<div class="sub-pop-up-window">
						<div class="information-progress">
							<div class="titles">
								<span>Progreso</span>
							</div>
							<div class="content-progress">
								<div class="sub-content-progress">
									<div class="title"><span>Otro curso</span></div>
									<div class="qualification"><?php echo $rowB['progres']; ?>%</div>
									<div class="end-progress"></div>
								</div>
							</div>
							<div class="content-progress">
								<div class="sub-content-progress">
									<div class="title"><span>Prevención de lavado de dinero</span></div>
									<div class="qualification"><?php echo $rowB['progres-2']; ?>%</div>
									<div class="end-progress"></div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>	

	<?php } ?>

</body>
</html>