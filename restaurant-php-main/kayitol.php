<html>
  <head>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body>
    <?php include "nav.php"; ?>
    <form method="post" class="mx-auto flex flex-col w-fit mt-4 gap-4">
      <input type="text" name="kullanici_adi" placeholder="kullanici adi" class="border rounded p-1 w-96">
      <input type="password" name="sifre" placeholder="sifre" class="border rounded p-1 w-96">
      <button class="border rounded px-12 hover:bg-neutral-200">Kayit ol</button>
    </form>
  </body>
</html>

<?php
  require_once "db.php";
  require_once "session.php";

  if($_SERVER['REQUEST_METHOD'] != "POST")
    return;
  
  $kullanici_adi = $_POST['kullanici_adi'];
  $sifre = $_POST['sifre'];

  $kullanici = $db->exec("INSERT INTO kullanicilar (kullanici_adi, sifre, tur) VALUES ('$kullanici_adi', '$sifre', 'musteri')");
  
  if(!$kullanici)
  {
    echo "Kayıt olma başarısız.";
    return;
  }

  $kullaniciId = $db->lastInsertId();
  $_SESSION["id"] = $kullaniciId;

  header("Location: anasayfa.php");
?>