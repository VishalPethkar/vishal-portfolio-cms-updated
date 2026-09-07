<?php
$page_title=ucfirst($_GET['section']??'Content'); require __DIR__.'/_header.php';
$allowed=['skills','projects','experience','education','certificates','services'];
$section=$_GET['section']??'projects'; if(!in_array($section,$allowed,true)) exit('Invalid section.');
$action=$_GET['action']??'list'; $id=(int)($_GET['id']??0);
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf(); $act=$_POST['act']??'';
 if($act==='delete'){db()->prepare("DELETE FROM portfolio_items WHERE id=? AND section=?")->execute([(int)$_POST['id'],$section]);header("Location: content.php?section=$section");exit;}
 if($act==='toggle'){db()->prepare("UPDATE portfolio_items SET is_visible=1-is_visible WHERE id=? AND section=?")->execute([(int)$_POST['id'],$section]);header("Location: content.php?section=$section");exit;}
 if($act==='save'){
   $data=[trim($_POST['title']),trim($_POST['subtitle']),trim($_POST['description']),trim($_POST['url']),trim($_POST['meta'])];
   if(!empty($_FILES['image']['name'])){ $allowedM=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];$type=mime_content_type($_FILES['image']['tmp_name']);if(isset($allowedM[$type])){$path='assets/uploads/'.uniqid('item_',true).'.'.$allowedM[$type];move_uploaded_file($_FILES['image']['tmp_name'],__DIR__.'/../'.$path);$data[]=$path;}}
   if($id){$sql="UPDATE portfolio_items SET title=?,subtitle=?,description=?,url=?,meta=?".(count($data)>5?",image=?":"")." WHERE id=? AND section=?";$vals=$data;$vals[]=$id;$vals[]=$section;db()->prepare($sql)->execute($vals);}
   else {$data[] = $data[5]??''; db()->prepare("INSERT INTO portfolio_items(section,title,subtitle,description,url,meta,image,sort_order) VALUES(?,?,?,?,?,?,?,(SELECT COALESCE(MAX(sort_order),0)+1 FROM portfolio_items x))")->execute([$section,...$data]);}
   header("Location: content.php?section=$section");exit;
 }
 if($act==='order'){
   foreach($_POST['order'] as $pos=>$itemId) db()->prepare("UPDATE portfolio_items SET sort_order=? WHERE id=? AND section=?")->execute([$pos+1,(int)$itemId,$section]);
   header("Location: content.php?section=$section");exit;
 }
}
if($action==='add'||$action==='edit'){
 $item=$id? (function()use($id,$section){$s=db()->prepare("SELECT * FROM portfolio_items WHERE id=? AND section=?");$s->execute([$id,$section]);return $s->fetch();})():['title'=>'','subtitle'=>'','description'=>'','url'=>'','meta'=>'','image'=>''];
?>
<div class="panel"><form method="post" enctype="multipart/form-data"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>">
<div class="form-grid"><div class="field"><label>Title</label><input name="title" value="<?=e($item['title'])?>" required></div><div class="field"><label>Subtitle / Role / Institute</label><input name="subtitle" value="<?=e($item['subtitle'])?>"></div><div class="field full"><label>Description</label><textarea name="description"><?=e($item['description'])?></textarea></div><div class="field"><label>URL</label><input name="url" value="<?=e($item['url'])?>"></div><div class="field"><label>Meta / Tech / Date</label><input name="meta" value="<?=e($item['meta'])?>"></div><div class="field"><label>Image</label><input type="file" name="image" accept="image/*"></div></div><br><div class="actions"><button class="btn" name="act" value="save">Save</button><a class="btn gray" href="content.php?section=<?=$section?>">Cancel</a></div></form></div>
<?php } else { $rows=db()->prepare("SELECT * FROM portfolio_items WHERE section=? ORDER BY sort_order,id");$rows->execute([$section]); ?>
<div class="panel"><div class="toolbar"><div class="muted">Drag/order values can be changed with the ↑/↓ buttons.</div><a class="btn" href="content.php?section=<?=$section?>&action=add">+ Add <?=e(rtrim(ucfirst($section),'s'))?></a></div>
<form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>">
<div class="table-wrap"><table><thead><tr><th>Order</th><th>Content</th><th>Visibility</th><th>Actions</th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td class="drag">#<?=e($r['sort_order'])?><input type="hidden" name="order[]" value="<?=$r['id']?>"></td><td><?php if($r['image']): ?><img class="thumb" src="../<?=e($r['image'])?>"><?php endif; ?><b><?=e($r['title'])?></b><div class="muted"><?=e($r['subtitle'])?></div></td><td><span class="badge <?=$r['is_visible']?'':'off'?>"><?=$r['is_visible']?'Visible':'Hidden'?></span></td><td class="actions"><a class="btn gray" href="content.php?section=<?=$section?>&action=edit&id=<?=$r['id']?>">Edit</a><button class="btn gray" name="act" value="toggle">Toggle</button><button class="btn red" name="act" value="delete" onclick="this.form.id.value='<?=$r['id']?>'">Delete</button></td></tr><?php endforeach; ?>
</tbody></table></div><input type="hidden" name="id" value=""><button class="btn" name="act" value="order">Save Order</button></form></div>
<?php } require __DIR__.'/_footer.php'; ?>
