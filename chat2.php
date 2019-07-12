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
		<div class="content-chats">

			<div class="sub-content-chats">
				<a href="chat.php"><button class="chat-off">Lavado de dinero</button></a>
				<a href="chat1.php"><button class="chat-off">Otro curso</button></a>
				<a href="chat2.php"><button class="chat-on">Otro curso</button></a>
			</div>

				<div class="sub-content-chat">
					<div class="content-chat-top">
						<div class="content-title-chat">Otro curso</div>
					</div>
					<div class="content-chat">
						<div class="content-mess">
							<?php 

								require "class/db.php";

								$sqlA = $mysqli->query("SELECT * FROM otro1 ORDER BY id ASC");
									while ($rowA = $sqlA->fetch_array()) {
									$sqlB = $mysqli->query("SELECT * FROM data WHERE id = '".$rowA['user']."'");
									$rowB = $sqlB->fetch_array();
							?>
					
							<a href="profile.php?username=<?php echo $rowB['username'];?>"><div><?php echo $rowB['username'];?></a>: <?php echo $rowA['message'];?></div>
							<?php } ?>
						</div>	
					
					</div>
					<div class="content-send">
						<form action="" method="post">
							<textarea class="text" name="messages"></textarea>
							<input type="submit" name="enviar" class="send" value="Enviar">
						</form>

						<?php

							if (isset($_POST['enviar'])) {
							require "class/db.php";

							$mensaje = $mysqli->real_escape_string($_POST['messages']);

							$ultpub = $mysqli->query("SELECT id FROM data WHERE id = '".$_SESSION['id']."'");
          					$ultp = $ultpub->fetch_array();

          					$query = "INSERT INTO otro1 (user,message,date) VALUES ('".$ultp['id']."','".$mensaje."',now())";

       						$mysqli->query($query); 

       						if($query) {header("refresh: 0; url = chat2.php");}
							}

						?>

					</div>
				</div>

		</div>
	</div>

</body>
</html>

<?php
ob_end_flush();
?>