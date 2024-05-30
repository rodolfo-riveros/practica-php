<?php
    $ser='localhost';
    $user='root';
    $passwor='';
    $bd='Hotel';
    $conexion = new mysqli($ser,$user,$passwor,$bd);
    if(!$conexion){die("no hay conexion".mysqli_error($conexion));
    }else{ echo"conectado";}
?>