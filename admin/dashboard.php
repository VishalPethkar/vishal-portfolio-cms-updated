<?php
$page_title='Dashboard'; require __DIR__.'/_header.php';
$counts=[]; foreach(['skills','projects','experience','education','certificates','services'] as $s){$q=db()->prepare("SELECT COUNT(*) FROM portfolio_items WHERE section=?");$q->execute([$s]);$counts[$s]=(int)$q->fetchColumn();}
$messages=(int)db()->query("SELECT COUNT(*) FROM contact_messages WHERE is_read=0")->fetchColumn();
?>
<div class="cards">
<?php foreach($counts as $k=>$v): ?><div class="stat"><div class="muted"><?=e(ucfirst($k))?></div><b><?=$v?></b></div><?php endforeach; ?>
<div class="stat"><div class="muted">Unread messages</div><b><?=$messages?></b></div>
</div>
<div class="panel"><div class="toolbar"><div><b>Quick actions</b><div class="muted">Everything is editable from the CMS.</div></div><div class="actions"><a class="btn" href="content.php?section=projects&action=add">+ Project</a><a class="btn gray" href="content.php?section=skills&action=add">+ Skill</a><a class="btn gray" href="settings.php">Site Settings</a></div></div></div>
<?php require __DIR__.'/_footer.php'; ?>
