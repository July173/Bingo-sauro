<?php

 
if (!empty($_POST["iniciarSesion"])) {
    if (!empty($_POST["correo"]) and !empty($_POST["password"])) {
        $email=$_POST["correo"];
        $contrasenia=$_POST["password"];
        $sql = require_once '../../../conexion_BD/conexion.php';
        $sql->query("SELECT * FROM credenciales WHERE correo = '$email' AND contrasena = '$contrasenia' ");
        if ($datos=$sql->fetch_object()) {
            header("location: ../inicioSesion/InicioSesion.html");
        }else{
            echo "<div class='alert alert-danger'>acceso denegado</div>";
        }
    }else{
        echo "campos vacios";
    }
}

?>

