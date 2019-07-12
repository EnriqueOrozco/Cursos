<?php 

	function datos_usuarios($id,$value){
		require "db.php";

		$id = $mysqli->real_escape_string($id);
		$value = $mysqli->real_escape_string($value);

		$datosZ = $mysqli->query("SELECT * FROM data WHERE id = $id");
		$rowZ = $datosZ->fetch_array();

		echo $rowZ[$value];
	}

 ?>