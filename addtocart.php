<?php

session_start();
require 'config/common.php';
require 'config/config.php';

if($_POST){
    $id = $_POST['id'];
    $qty = $_POST['qty'];

    $stmt = $pdo->prepare("SELECT * from products WHERE id=".$id);
    $stmt->execute();
    $result= $stmt->fetch(PDO::FETCH_ASSOC);

    if($qty > $result['quantity']){
        echo "<script>alert('Not enough Stock');window.location.href='product_detail.php?id=$id';</script>";
        die();
    }else{
        if(isset($_SESSION['cart']['id'.$id])){
            $_SESSION['cart']['id'.$id] += $qty;
        }else{
            $_SESSION['cart']['id'.$id] = $qty;
        }
        
        header("Location: cart.php");
    }

   
}


?>