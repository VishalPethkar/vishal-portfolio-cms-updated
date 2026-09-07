<?php
$page_title='Messages'; require __DIR__.'/_header.php';
if($_SERVER['REQUEST_METHOD']==='POST'){verify_csrf();db()->prepare("UPDATE contact_messages SET is_read=1 WHERE id=?")->execute([(int)$_POST['id']]);header('Location: messages.php');exit;}
$rows=db()->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetchAll();
?>
<div class="panel"><div class="table-wrap"><table><thead><tr><th>Date</th><th>Name</th><th>Email</th><th>Message</th><th>Status</th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td><?=e($r['created_at'])?></td><td><b><?=e($r['name'])?></b></td><td><?=e($r['email'])?></td><td><?=nl2br(e($r['message']))?></td><td><?php if(!$r['is_read']): ?><form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><input type="hidden" name="id" value="<?=$r['id']?>"><button class="btn" type="submit">Mark read</button></form><?php else: ?><span class="badge">Read</span><?php endif; ?></td></tr><?php endforeach; ?>
</tbody></table></div></div>
<?php require __DIR__.'/_footer.php'; ?>
