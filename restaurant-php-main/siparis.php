<?php 
  include "nav.php";
  require_once "db.php";
  require_once "session.php";
  
  if(!isset($_POST['siparis'])){
    header("Location: anasayfa.php");
    return;
  }

  $menuler = $_POST['menu'];
  $restaurant_id = $_POST['restaurant_id'];
  $menuisimleri = implode(',', $menuler);
  setcookie("menu",$menuisimleri,time()+(60*60*12));
  $islem = $db->query("SELECT * FROM menuler WHERE menu_id IN ($menuisimleri)")->fetchAll();
  $toplam = 0;
  foreach($islem as $i){
    $toplam += $i['fiyat'];
  }
  
  $user = $db->query("SELECT * FROM kullanicilar WHERE id = {$_SESSION['id']}")->fetch();
?>

<html>
  <head>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
    <body>
      <div class="flex flex-col items-center justify-center gap-6 p-6">
        <p class="text-lg">Sayın: <span class="text-blue-400"><?php echo $user['kullanici_adi'] ?></span></p>
        <p class="text-xl">Toplam tutar: <?php echo $toplam ; ?>TL</p> 
        <?php if($user['cuzdan'] >= $toplam) { ?>
          <form class="flex flex-col gap-4" action="siparisOnay.php" method="post">
            <input type="hidden" name="restaurant_id" value="<?php echo $restaurant_id ?>">
              <input class="border rounded" required type="datetime-local" name="gun">
              <div class="mx-auto">
                <button class="p-1 bg-green-600 text-white rounded border" name="onayla">Siparisi onayla</button>
                <a class="text-red-400" href="anasayfa.php">Iptal</a>
              </div>
          </form>
        <?php } else { ?>
          <?php echo $toplam - $user['cuzdan'] ?> TL Eksik. Lütfen bakiye yükleyiniz.
        <?php } ?>
      </div>
    </body>
</html>