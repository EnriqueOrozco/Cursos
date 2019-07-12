<?php 
	ob_start();
	session_start();
	if (!isset($_SESSION['logueado']) && $_SESSION['logueado'] == FALSE) {
		header("location: index.php");
	}

	error_reporting(0);
	include "class/functions.php";

?>

<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Curso</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/fonts.css">
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

	<?php include "header.php" ?>

<form action="" method="post" enctype="multipart/form-data">  

  <div class="" style="margin-left: 45%;">
    <div class="">
        <label for="file-input">
          <img src="imagenes/1.png" width="50" title ="Sube una foto ó video" >
        </label>
        <input id="file-input" type="file" name="file-input" hidden="" />
    </div>
  </div>

  <body onload="capturar()">



 
  <div style="float: left; clear: both; width: 600px; margin-left: 29%;">
   <div id="resultado" class=""><img id="imgSalida" width="600" /></div>
  </div>

  <div style="float: left; clear: both; margin-top: 30px; margin-bottom: 30px; margin-left: 25%;">
   <textarea rows="6" cols="100%" name="descripcions" placeholder="Descripción de tu publicación"></textarea>
  </div>

  <div style="float: left; clear: both; margin-left: 43.5%;">
   <input name="submit" class="up" type="submit" value="Compartir">   
  </div>
</form> 

<?php  
if (isset($_POST['submit'])) {

  require "class/db.php";

  $imagen = $_FILES['file-input']['tmp_name'];   
  $imagen_tipo = exif_imagetype($_FILES['file-input']['tmp_name']);

  if ($imagen_tipo == IMAGETYPE_PNG OR $imagen_tipo == IMAGETYPE_JPEG OR $imagen_tipo == IMAGETYPE_BMP OR $imagen_tipo == IMAGETYPE_GIF) {

  $filtro = $mysqli->real_escape_string($_POST['filter']);
  $descripcions = $mysqli->real_escape_string($_POST['descripcions']);

    if(is_uploaded_file($_FILES['file-input']['tmp_name'])) { 

        $result = $mysqli->query("SHOW TABLE STATUS WHERE `Name` = 'archive'");
        $data = $result->fetch_assoc();
        $next_id = $data['Auto_increment'];

        $ext = ".gif"; 
        $namefinal = trim ($_FILES['file-input']['name']);
        $namefinal = str_replace (" ", "", $namefinal);
        $aleatorio = substr(strtoupper(md5(microtime(true))), 0,6);
        $namefinal = 'ID-'.$next_id.'-NAME-'.$aleatorio; 

        if ($imagen_tipo == IMAGETYPE_PNG) {
          $image = imagecreatefrompng($imagen);
          imagejpeg($image, 'archive/'.$namefinal.$ext, 100);           

          $nuevaimagen = 'archive/'.$namefinal.$ext;
        }

        else {
          $nuevaimagen = $imagen;
        }

        $original = imagecreatefromjpeg($nuevaimagen);
        $max_ancho = 1080; $max_alto = 1080;
        list($ancho,$alto)=getimagesize($nuevaimagen);

        $x_ratio = $max_ancho / $ancho;
        $y_ratio = $max_alto / $alto;

        if(($ancho <= $max_ancho) && ($alto <= $max_alto) ){
            $ancho_final = $ancho;
            $alto_final = $alto;
        }
        else if(($x_ratio * $alto) < $max_alto){
            $alto_final = ceil($x_ratio * $alto);
            $ancho_final = $max_ancho;
        }
        else {
            $ancho_final = ceil($y_ratio * $ancho);
            $alto_final = $max_alto;
        }

        $lienzo=imagecreatetruecolor($ancho_final,$alto_final); 

        imagecopyresampled($lienzo,$original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
         
        imagedestroy($original);

        imagejpeg($lienzo,"archive/".$namefinal.$ext);

      }


        if($_FILES['file-input']['tmp_name']) {

          $queryp = $mysqli->query("INSERT INTO publications (user,descripcions,date) VALUES ('".$_SESSION['id']."','".$descripcions."',now())");

          $ultpub = $mysqli->query("SELECT id FROM publications WHERE user = '".$_SESSION['id']."' ORDER BY id DESC LIMIT 1");
          $ultp = $ultpub->fetch_array();

          $query = "INSERT INTO archive (user,route,type,size,publications,filtro,date) VALUES ('".$_SESSION['id']."','".$namefinal.$ext."','".$_FILES['file-input']['type']."','".$_FILES['file-input']['size']."','".$ultp['id']."','".$filtro."',now())";

          $mysqli->query($query); 

          if($query) {header("refresh: 0; url = home.php");}
        }  
    }  

     else {echo "<script type='text/javascript'>alert('Solo puedes subir imágenes');</script>";}
 } 
?> 

</body>
</html>

<?php
ob_end_flush();
?>