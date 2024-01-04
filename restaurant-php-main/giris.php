<html>
  <head>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body>
    <?php include "nav.php"; ?>
    <form method="post" class="mx-auto flex flex-col w-fit mt-4 gap-4">
      <input type="text" name="kullanici_adi" placeholder="kullanici adi" class="border rounded p-1 w-96">
      <input type="password" name="sifre" placeholder="sifre" class="border rounded p-1 w-96">
      <button name="giris" class="border rounded px-12 hover:bg-neutral-200">Giris yap</button>
      <a href="kayitol.php" class="text-center text-sm ">Hesabiniz mi yok? Kayit olun!</a>
    </form>
  </body>
</html>

<?php 
  require_once "db.php";
  require_once "session.php";

  if($_SERVER['REQUEST_METHOD'] != "POST" || !isset($_POST["giris"]))
    return;
  
  $kullanici_adi=$_POST["kullanici_adi"];
  $sifre=$_POST["sifre"];

  $kullanici=$db->query("SELECT * FROM kullanicilar WHERE kullanici_adi ='$kullanici_adi'")->fetch();
  if($kullanici['id'] == "")
  {
      echo "Kullanıcı Bulunamadı";
      return;
  }
  
  if($kullanici_adi == $kullanici['kullanici_adi'] and $sifre == $kullanici['sifre'])
  {
      $_SESSION["id"] = $kullanici['id'];
      header("Location: anasayfa.php");
  }
?>