<?php
  include "nav.php";
  require_once "session.php";
  require_once "db.php";

  if(empty($_SESSION['id'])) {
    header("Location: giris.php");
    return;
  }

  $kullanici = $db->query("SELECT * FROM kullanicilar WHERE id = " . $_SESSION['id'])->fetch();
  if($kullanici['tur'] != 'admin') {
    header("Location: anasayfa.php");
    return;
  }

  $restaurantlar = $db->query("SELECT * FROM restaurant INNER JOIN kullanicilar ON restaurant.sahip = kullanicilar.id");

  if(isset($_POST['restoranKayit'])){
    $sahip = $_POST['sahip'];
    $isim = $_POST['isim'];
    $iletisim = $_POST['iletisim'];
    $adres = $_POST['adres'];

    $db->query("INSERT INTO restaurant (isim, iletisim, adres, sahip) VALUES ('$isim', '$iletisim', '$adres', $sahip)");
    header("Location: admin.php");
  }

  if(isset($_POST['sil'])){
    $id = $_POST['id'];
    $sil= $db->exec("DELETE FROM restaurant WHERE restaurant_id='$id'");
    header("Location: admin.php");
  }
?>

<html>
  <head>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body>
    <div class="flex gap-4 items-center justify-center my-2">
      <a class="border rounded hover:bg-neutral-200 p-1" href="adminRest.php">Restoranlar Kontrol</a>
      <a class="border rounded hover:bg-neutral-200 p-1" href="adminUser.php">Üyeler Kontrol</a>
    </div>
    <hr>
    <div>
      <form method="POST" class="mx-auto flex flex-col w-fit mt-4 gap-1">
          <label for="sahip" >Sahibi:</label><input name="sahip" type="text" class="border rounded p-1 w-96"> <br>
          <label for="isim" >İş Yeri İsmi:</label><input name="isim" type="text" class="border rounded p-1 w-96"><br>
          <label for="iletisim" >İletişim:</label><input name="iletisim" type="text" class="border rounded p-1 w-96"><br>
          <label for="adres" >Adres:</label><textarea name="adres" class="border rounded p-1 w-96"></textarea> <br>
          <button name="restoranKayit" class="border rounded px-12 hover:bg-neutral-200">Kayıt</button>
      </form>
    </div>
  </body>
</html>