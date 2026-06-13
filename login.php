<?php
session_start();
require_once 'db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    
    $stmt = $pdo->prepare("SELECT * FROM stores WHERE email = ? AND password = ?");
    $stmt->execute([$email, $password]);
    $store = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($store) {
        $_SESSION['store_id'] = $store['id'];
        $_SESSION['store_name'] = $store['store_name'];
        header('Location: dashboard.php');
        exit;
    } else {
        header('Location: index.php?error=1');
        exit;
    }
}
?>