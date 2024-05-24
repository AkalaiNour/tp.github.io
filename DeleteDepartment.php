<?php
    require_once 'connexion.php';
    $ID=$_GET['ID'];
    $sqlStat = $pdo->prepare('DELETE FROM admin WHERE ID_ADMIN=?');
    $supp=$sqlStat->execute([$ID]);
    $pdo->exec('ALTER TABLE admin AUTO_INCREMENT = 1');
    if($supp){
        header('location:departement.php');
    }else{
        echo "Database Error";
    }
?>