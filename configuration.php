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
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Curso</title>
	<link rel="stylesheet" href="css/fonts.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="js/jquery-3.1.1.min.js"></script>
	<script src="js/main.js"></script>
	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 

    <script type="text/javascript">
    $(window).load(function(){
     $(function() {
      $('#file-input').change(function(e) {
          addImage(e); 
         });

         function addImage(e){
          var file = e.target.files[0],
          imageType = /image.*/;
        
          if (!file.type.match(imageType))
           return;
      
          var reader = new FileReader();
          reader.onload = fileOnload;
          reader.readAsDataURL(file);
         }
      
         function fileOnload(e) {
          var result=e.target.result;
          $('#imgSalida').attr("src",result);
         }
        });
      });
    </script>

    <script>
      function capturar()
      {
            var resultado="";
     
            var porNombre=document.getElementsByName("filter");
            for(var i=0;i<porNombre.length;i++)
            {
                if(porNombre[i].checked)
                    resultado=porNombre[i].value;
            }

        var elemento = document.getElementById("resultado");
        if (elemento.className == "") {
          elemento.className = resultado;
          elemento.width = "600";
        }else {
          elemento.className = resultado;
          elemento.width = "600";
        }
    }
    </script>
</head>
<body>

	<?php 

		require "class/db.php";

		$sqlA = $mysqli->query("SELECT * FROM data WHERE id = '".$_SESSION['id']."'");
		$rowA = $sqlA->fetch_array();

	?>
	
	<?php include "header.php" ?>

	<div class="content">
		<div class="content-edit">

			<div class="sub-content-option">
				<a href="configuration.php"><button class="button_on">Editar perfil</button></a>
				<a href="configuration-password.php"><button class="button_off">Cambiar contraseña</button></a>
				<a href="configuration-apk.php"><button class="button_off">Aplicacion</button></a>
			</div>
			
			<form action="" method="post" enctype="multipart/form-data">
				
				<?php 

					if (isset($_POST['editar'])) {
						require "class/db.php";

						$avatar = $mysqli->real_escape_string($_FILES['avatar']['name']);
						$ruta = $_FILES['avatar']['tmp_name'];
						$destino = "images/".$avatar;
						copy($ruta, $destino);
						$nombre = $mysqli->real_escape_string($_POST['nombre']);
						$username = $mysqli->real_escape_string($_POST['username']);
						$biography = $mysqli->real_escape_string($_POST['biography']);
						$email = $mysqli->real_escape_string($_POST['email']);

						$sqlB = $mysqli->query("SELECT * FROM data WHERE username = '$username' AND id != '".$_SESSION['id']."'");
						$totalusuarios = $sqlB->num_rows;

						$sqlC = $mysqli->query("SELECT * FROM data WHERE email = '$email' AND id != '".$_SESSION['id']."'");
						$totalemail = $sqlC->num_rows;

						if ($totalusuarios > 0) {
							$existe = "Ya hay un usuario con este nombre";
						}

						elseif ($totalemail > 0){
							$existe2 = "Ya hay un emial registrado";
						}

						else{
							$sqlE = $mysqli->query("UPDATE data SET avatar = '$destino', name = '$nombre', username = '$username', biography = '$biography', email = '$email' WHERE id = '".$_SESSION['id']."'");


							if($sqlE) {
								header ('location: configuration.php');
							}
						}

					}

				?>
				
				<div class="sub-content-edit">
					<div class="content-of-edit">
						<div class="content-title"><img src="<?php echo $rowA['avatar'];?>" width="60"></div>
						<div class="content-input"><?php echo $rowA['username'];?>
							<label for="file-input"><p>Cambiar foto de perfil</p></label>
							<input id="file-input" type="file" name="avatar" value="avatar" hidden="" />
							 <div style="float: left; width: 60px; margin-left: 29%;">
   								<div id="resultado" class=""><img id="imgSalida" width="60" /></div>
  							</div>
						</div>
					</div>
					<div class="content-of-edit">
						<div class="content-titles">Nombre</div>
						<div class="content-input"><input type="text" name="nombre" value="<?php echo $rowA['name'];?>" autocomplete="off"></div>
					</div>
					<div class="content-of-edit">
						<div class="content-titles">Nombre de usuario</div>
						<div class="content-input"><input type="text" name="username" value="<?php echo $rowA['username'];?>" autocomplete="off"></div>
						<div style="color:red; font-size: 12px;"><?php if(isset($existe)) {echo $existe;} ?></div>
					</div>
					<div class="content-of-edit">
						<div class="content-titles">Biografía</div>
						<div class="content-input"><input type="text" name="biography" value="<?php echo $rowA['biography'];?>" autocomplete="off"></div>
					</div>
					<div class="content-of-edit">
						<div class="content-titles">Correo electrónico</div>
						<div class="content-input"><input type="text" name="email" value="<?php echo $rowA['email'];?>" autocomplete="off"></div>
						<div style="color:red; font-size: 12px;"><?php if(isset($existe2)) {echo $existe2;} ?></div>
					</div>
					<div class="content-of-edit">
						<div class="content-titles">Sexo</div>
						<div class="content-input">
							<select disabled="">
								<option value="">Sin especificar</option>
								<option value="0">Hombre</option>
								<option value="1">Mujer</option>
							</select>
						</div>
					</div>
					<div class="content-of-edit">
						<div class="content-titles"></div>
						<div class="content-button">
							<input type="submit" class="save" name="editar" value="Guardar cambios">
						</div>
					</div>
				</div>

			</form>
		</div>
	</div>
	

</body>
</html>