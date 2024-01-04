<?php 
  require_once "db.php";
  require_once "session.php";

  if(!isset($_POST['duzenle']))
    return;

  if(empty($_SESSION['id'])) {
    header("Location: giris.php");
    return;
  }

  $kullanici = $db->query("SELECT * FROM kullanicilar WHERE id = " . $_SESSION['id'])->fetch();

  if($kullanici['tur'] != 'admin') {
    header("Location: anasayfa.php");
    return;
  }

  $id =$_POST['id'];
  $kullanici_adi =$_POST['kullanici_adi'];
  $sifre = $_POST['sifre'];
  $tur = $_POST['tur'];

  $db->query("UPDATE kullanicilar SET kullanici_adi='$kullanici_adi', sifre='$sifre', tur='$tur' WHERE id='$id'");
  header("Location: adminUser.php");

?>