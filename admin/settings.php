<?php
$page_title='Site Settings'; require __DIR__.'/_header.php';
$s=db()->query("SELECT * FROM site_settings WHERE id=1")->fetch();
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf();
 $data=['site_name'=>trim($_POST['site_name']),'tagline'=>trim($_POST['tagline']),'hero_title'=>trim($_POST['hero_title']),'hero_text'=>trim($_POST['hero_text']),'email'=>trim($_POST['email']),'phone'=>trim($_POST['phone']),'location'=>trim($_POST['location']),'github'=>trim($_POST['github']),'linkedin'=>trim($_POST['linkedin']),'instagram'=>trim($_POST['instagram']),'form_endpoint'=>trim($_POST['form_endpoint'])];
 foreach(['profile_image'=>'profile_image','resume_file'=>'resume_file'] as $field=>$key){
   if(!empty($_FILES[$field]['name'])){
     $allowed=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp','application/pdf'=>'pdf'];
     $type=mime_content_type($_FILES[$field]['tmp_name']);
     if(!isset($allowed[$type])) exit('Unsupported upload type.');
     $name='assets/uploads/'.uniqid('file_',true).'.'.$allowed[$type];
     move_uploaded_file($_FILES[$field]['tmp_name'],__DIR__.'/../'.$name); $data[$key]=$name;
   }
 }
 $set=[];$vals=[];foreach($data as $k=>$v){$set[]="$k=?";$vals[]=$v;}$vals[] = 1;
 db()->prepare("UPDATE site_settings SET ".implode(',',$set)." WHERE id=?")->execute($vals);
 $s=db()->query("SELECT * FROM site_settings WHERE id=1")->fetch(); echo '<div class="flash">Saved successfully.</div>';
}
?>
<div class="panel"><form method="post" enctype="multipart/form-data"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>">
<div class="form-grid">
<div class="field"><label>Site name</label><input name="site_name" value="<?=e($s['site_name'])?>" required></div>
<div class="field"><label>Tagline</label><input name="tagline" value="<?=e($s['tagline'])?>"></div>
<div class="field full"><label>Hero title</label><input name="hero_title" value="<?=e($s['hero_title'])?>"></div>
<div class="field full"><label>Hero/About text</label><textarea name="hero_text"><?=e($s['hero_text'])?></textarea></div>
<div class="field"><label>Email</label><input name="email" value="<?=e($s['email'])?>"></div>
<div class="field"><label>Phone</label><input name="phone" value="<?=e($s['phone'])?>"></div>
<div class="field"><label>Location</label><input name="location" value="<?=e($s['location'])?>"></div>
<div class="field"><label>GitHub URL</label><input name="github" value="<?=e($s['github'])?>"></div>
<div class="field"><label>LinkedIn URL</label><input name="linkedin" value="<?=e($s['linkedin'])?>"></div>
<div class="field"><label>Instagram URL</label><input name="instagram" value="<?=e($s['instagram'])?>"></div>
<div class="field"><label>Contact form endpoint (optional)</label><input name="form_endpoint" value="<?=e($s['form_endpoint'])?>"></div>
<div class="field"><label>Profile image</label><input type="file" name="profile_image" accept="image/*"></div>
<div class="field"><label>Resume PDF</label><input type="file" name="resume_file" accept="application/pdf"></div>
</div><br><button class="btn" type="submit">Save Site Settings</button></form></div>
<?php require __DIR__.'/_footer.php'; ?>
