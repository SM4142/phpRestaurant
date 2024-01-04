<?php
require_once "session.php";
require_once "db.php";
if (isset($_POST['duzenle'])) {
    $isim = $_POST['isim1'];
    $iletisim = $_POST['iletisim1'];
    $adres = $_POST['adres1'];
    $id1 = $_POST['id1'];
    $duzenle = $db->query("UPDATE restaurant SET isim='$isim' ,iletisim='$iletisim' , adres='$adres' WHERE restaurant_id='$id1'  ");
    header("Location: adminRest.php");
}
?>