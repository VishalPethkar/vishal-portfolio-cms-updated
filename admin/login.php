<?php
require __DIR__ . '/../config/config.php';
if (!empty($_SESSION['admin_id'])) { header('Location: dashboard.php'); exit; }
$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    verify_csrf();
    $s=db()->prepare("SELECT * FROM admins WHERE email=? LIMIT 1"); $s->execute([trim($_POST['email']??'')]); $admin=$s->fetch();
    if ($admin && password_verify($_POST['password']??'', $admin['password_hash'])) {
        session_regenerate_id(true); $_SESSION['admin_id']=$admin['id']; $_SESSION['admin_name']=$admin['name']; header('Location: dashboard.php'); exit;
    }
    $error='Invalid email or password.';
}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Login</title><link rel="stylesheet" href="admin.css"></head>
<body class="login"><div class="login-card"><h1>VP CMS</h1><p class="muted">Sign in to manage your portfolio.</p><?php if($error): ?><div class="danger"><?=e($error)?></div><?php endif; ?><form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><input type="email" name="email" placeholder="Admin email" required><input type="password" name="password" placeholder="Password" required><button class="btn" type="submit">Sign in</button></form></div></body></html>
