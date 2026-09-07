<?php
require __DIR__ . '/config/config.php';
$settings = db()->query("SELECT * FROM site_settings WHERE id=1")->fetch();
if (!$settings) {
    $settings = ['site_name'=>'Vishal Pethkar','tagline'=>'Data Analyst','hero_title'=>'Vishal Pethkar','hero_text'=>'Welcome to my portfolio.','profile_image'=>'assets/profile.jpg','resume_file'=>'assets/resume.pdf','email'=>'','phone'=>'','location'=>'','github'=>'','linkedin'=>'','instagram'=>''];
}
$sections = [];
$stmt = db()->query("SELECT * FROM portfolio_items WHERE is_visible=1 ORDER BY section, sort_order, id");
foreach ($stmt as $row) $sections[$row['section']][] = $row;
function items($sections, $key) { return $sections[$key] ?? []; }
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($settings['site_name']) ?> | <?= e($settings['tagline']) ?></title>
<link rel="stylesheet" href="assets/site.css">
</head>
<body>
<header class="nav">
  <a class="brand" href="#home"><?= e($settings['site_name']) ?></a>
  <nav>
    <a href="#about">About</a><a href="#skills">Skills</a><a href="#projects">Projects</a>
    <a href="#experience">Experience</a><a href="#education">Education</a><a href="#contact">Contact</a>
    <button id="themeBtn" class="icon-btn" aria-label="Toggle theme">◐</button>
  </nav>
</header>

<main>
<section id="home" class="hero">
  <div class="hero-copy">
    <span class="eyebrow">PORTFOLIO • <?= e($settings['tagline']) ?></span>
    <h1><?= e($settings['hero_title']) ?></h1>
    <p><?= nl2br(e($settings['hero_text'])) ?></p>
    <div class="actions">
      <?php if (!empty($settings['resume_file'])): ?><a class="btn" href="<?= e($settings['resume_file']) ?>" target="_blank">View Resume</a><?php endif; ?>
      <a class="btn ghost" href="#contact">Let's Connect</a>
    </div>
  </div>
  <div class="hero-photo"><img src="<?= e($settings['profile_image']) ?>" alt="<?= e($settings['site_name']) ?>"></div>
</section>

<section id="about" class="section narrow">
  <div class="section-head"><span>01</span><h2>About</h2></div>
  <p class="lead"><?= nl2br(e($settings['hero_text'])) ?></p>
</section>

<section id="skills" class="section">
  <div class="section-head"><span>02</span><h2>Skills</h2></div>
  <div class="chips">
  <?php foreach (items($sections,'skills') as $x): ?><span class="chip"><?= e($x['title']) ?></span><?php endforeach; ?>
  </div>
</section>

<section id="projects" class="section">
  <div class="section-head"><span>03</span><h2>Projects</h2></div>
  <div class="grid">
  <?php foreach (items($sections,'projects') as $x): ?>
    <article class="card">
      <?php if ($x['image']): ?><img src="<?= e($x['image']) ?>" alt="<?= e($x['title']) ?>"><?php endif; ?>
      <div class="card-body"><span class="muted"><?= e($x['meta']) ?></span><h3><?= e($x['title']) ?></h3><p><?= e($x['description']) ?></p>
      <?php if ($x['url']): ?><a class="text-link" href="<?= e($x['url']) ?>" target="_blank" rel="noopener">View project →</a><?php endif; ?></div>
    </article>
  <?php endforeach; ?>
  </div>
</section>

<section id="experience" class="section">
  <div class="section-head"><span>04</span><h2>Experience</h2></div>
  <div class="timeline"><?php foreach(items($sections,'experience') as $x): ?><div class="timeline-item"><b><?= e($x['title']) ?></b><span><?= e($x['subtitle']) ?></span><p><?= e($x['description']) ?></p></div><?php endforeach; ?></div>
</section>

<section id="education" class="section">
  <div class="section-head"><span>05</span><h2>Education & Certificates</h2></div>
  <div class="grid">
  <?php foreach(array_merge(items($sections,'education'),items($sections,'certificates')) as $x): ?><article class="mini-card"><span class="muted"><?= e($x['section']) ?></span><h3><?= e($x['title']) ?></h3><p><?= e($x['subtitle']) ?></p><p><?= e($x['description']) ?></p><?php if($x['url']): ?><a class="text-link" href="<?= e($x['url']) ?>" target="_blank">Open →</a><?php endif; ?></article><?php endforeach; ?>
  </div>
</section>

<section id="services" class="section">
  <div class="section-head"><span>06</span><h2>Services</h2></div>
  <div class="grid"><?php foreach(items($sections,'services') as $x): ?><article class="mini-card"><h3><?= e($x['title']) ?></h3><p><?= e($x['description']) ?></p></article><?php endforeach; ?></div>
</section>

<section id="contact" class="section contact">
  <div><div class="section-head"><span>07</span><h2>Let's Connect</h2></div><p>Have a project, internship or collaboration idea? Send a message.</p><div class="contact-lines"><?php if($settings['email']): ?><div><?= e($settings['email']) ?></div><?php endif; ?><?php if($settings['phone']): ?><div><?= e($settings['phone']) ?></div><?php endif; ?><?php if($settings['location']): ?><div><?= e($settings['location']) ?></div><?php endif; ?></div></div>
  <form action="contact.php" method="post"><input name="name" placeholder="Your name" required><input name="email" type="email" placeholder="Email" required><textarea name="message" rows="6" placeholder="Your message" required></textarea><button class="btn" type="submit">Send Message</button></form>
</section>
</main>
<footer>© <?= date('Y') ?> <?= e($settings['site_name']) ?> · Managed from Admin CMS</footer>
<script>
document.getElementById('themeBtn').onclick=()=>{document.body.classList.toggle('dark');localStorage.theme=document.body.classList.contains('dark')?'dark':'light'};
if(localStorage.theme==='dark')document.body.classList.add('dark');
</script>
</body></html>
