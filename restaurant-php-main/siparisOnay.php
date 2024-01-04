<?php 
  include "nav.php";
  require_once "db.php";
  require_once "session.php";
  
  if(!isset($_POST['onayla'])){
    header("Location: anasayfa.php");
    return;
  }
  
  $menuisimleri = $_COOKIE["menu"];
  $restaurant_id = $_POST['restaurant_id'];
  $gun = $_POST['gun'];
  $islem = $db->query("SELECT * FROM menuler WHERE menu_id IN ($menuisimleri)")->fetchAll();
  $toplam = 0;
  foreach($islem as $i){
    $toplam += $i['fiyat'];
  }
  
  $db->exec("UPDATE kullanicilar SET cuzdan = cuzdan - $toplam WHERE id = {$_SESSION['id']}");
  $db->exec("INSERT INTO siparisler (kullanici_id,menuler,tutar,zaman,restaurant_id) VALUES ('{$_SESSION['id']}','$menuisimleri','$toplam','$gun','$restaurant_id')");
?>

<html>
  <head>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
    <body>
      <div class="flex items-center justify-center flex-col">
        <p class="text-xl text-center mt-4">Siparisiniz alinmistir. Afiyet olsun.</p>
        <p>3 saniye icinde anasayfaya yonlendirileceksiniz...</p>
        <a href="anasayfa.php">Anasayfa</a>
      </div>
      <script>
        setTimeout(() => {
          window.location.href = "anasayfa.php";
        }, 3000);
      </script>
    </body>
</html>