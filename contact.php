<?php
require __DIR__ . '/config/config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php#contact'); exit; }
$name=trim($_POST['name']??''); $email=trim($_POST['email']??''); $message=trim($_POST['message']??'');
if ($name && filter_var($email,FILTER_VALIDATE_EMAIL) && $message) {
    $s=db()->prepare("INSERT INTO contact_messages(name,email,message) VALUES(?,?,?)");
    $s->execute([$name,$email,$message]);
}
header('Location: index.php#contact'); exit;
