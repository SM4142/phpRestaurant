<?php 
  require_once "session.php";
  require_once "db.php";
?>

<div class="flex border-b items-center py-2 px-4 gap-8 text-2xl tracking-tighter">
  <a href="anasayfa.php" class="">Ana sayfa</a>
  <form action="ara.php" class="flex items-center justify-center text-lg my-auto gap-2">
        <input type="text" name="q" placeholder="kebab... lahmacun..." class="border rounded w-96">
        <button class="border rounded px-12 hover:bg-neutral-200">Ara</button>
  </form>
  <span class="ml-auto"></span>
  <?php if(!empty($_SESSION['id'])) { ?>
    <?php $kullanici = $db->query("SELECT * FROM kullanicilar WHERE id = " . $_SESSION['id'])->fetch() ?>
    <a href="rezer.php">Rezervasyonlar</a>
    <?php if($kullanici['tur'] == 'yonetici') { ?>
      <a href="yonetim.php">Restoran Yonetim</a>
    <?php } ?>
    <?php if($kullanici['tur'] == 'admin') { ?>
      <a href="admin.php">Admin Yonetim</a>
    <?php } ?>
    <p><?php echo $kullanici['cuzdan'] ?> ₺</p>
    <p>Hoşgeldin, <?php echo $kullanici['kullanici_adi']?></p>
    <form method="post" action="cikis.php" class="contents">
      <button class="" name="cikis">Cikis yap</button>
    </form>
  <?php } else { ?>
    <a href="giris.php">Giris</a>
    <a href="kayitol.php">Kayıt</a>
  <?php } ?>
</div>