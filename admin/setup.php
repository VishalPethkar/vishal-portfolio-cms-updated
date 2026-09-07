<?php
require __DIR__ . '/../config/config.php';
$msg=''; $error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    verify_csrf();
    try {
        db()->exec(file_get_contents(__DIR__.'/../database/schema.sql'));
        $name=trim($_POST['name']); $email=trim($_POST['email']); $pass=$_POST['password'];
        if(strlen($pass)<8) throw new Exception('Password must be at least 8 characters.');
        $s=db()->prepare("INSERT INTO admins(name,email,password_hash) VALUES(?,?,?) ON DUPLICATE KEY UPDATE name=VALUES(name), password_hash=VALUES(password_hash)");
        $s->execute([$name,$email,password_hash($pass,PASSWORD_DEFAULT)]);
        $msg='Setup complete. Delete admin/setup.php after signing in.';
    } catch(Throwable $e) { $error=$e->getMessage(); }
}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>CMS Setup</title><link rel="stylesheet" href="admin.css"></head>
<body class="login"><div class="login-card"><h1>VP CMS Setup</h1><p class="muted">First create the database tables and admin account.</p><?php if($msg): ?><div class="flash"><?=e($msg)?></div><a class="btn" href="login.php">Go to Login</a><?php endif; ?><?php if($error): ?><div class="danger"><?=e($error)?></div><?php endif; ?><form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><input name="name" placeholder="Your name" value="Vishal Pethkar" required><input type="email" name="email" placeholder="Admin email" required><input type="password" name="password" placeholder="New password (8+ characters)" required><button class="btn" type="submit">Install CMS</button></form></div></body></html>
