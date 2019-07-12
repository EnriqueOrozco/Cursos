<?php

$mysqli = new mysqli("localhost", "root", "awdx1234,.-", "cursos");

if($mysqli->connect_errno) {
    echo "Falló la conexion a la base de datos";
}

return $mysqli;

?>
