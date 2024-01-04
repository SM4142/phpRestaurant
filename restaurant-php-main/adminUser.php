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
  $user = $db ->query("SELECT * FROM kullanicilar");

  if(isset($_POST['sil'])){
    $id = $_POST['id'];
    $sil= $db->exec("DELETE FROM kullanicilar WHERE id='$id'");
    header("Location: adminUser.php");
  }


  

?>
<html>
  <head>
      <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body>
  <div class="container flex mx-auto">
      <table class="min-w-full m-4">
          <tr class="border-b font-bold">
              <td>
                  ID
              </td>
              <td>
                  Kullancı Adı
              </td>
              <td>
                  Şifre
              </td>
              <td>
                  Tur
              </td>
              <td>
                  İşlemler
            </td>
          </tr>
          <?php if(!isset($_POST['guncelle'])) { ?>
          <?php foreach($user as $key =>$person) : ?>
            <tr>
              <td>
                  <?php echo $person['id'] ?>
              </td>
              <td>
                  <?php echo $person['kullanici_adi']?>
              </td>
              <td>
                  <?php echo $person['sifre']?>
              </td>
              <td>
                  <?php echo $person['tur']?>
              </td>
              <td>
                <form method="post">
                  <input type="hidden" value="<?php echo $person['id'] ?>" name="id">
                  <button class="bg-red-400 rounded p-1" name="sil">Sil</button>
                  <button class="bg-blue-400 rounded p-1" name="guncelle">Güncelle</button>
                </form>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php } else { ?>
              <?php
              $id = $_POST['id'];
              $person = $db ->query("SELECT * FROM kullanicilar WHERE id='$id'")->fetch();

              ?>
                <form action="kullaniciGuncelle.php" method="post">
                <tr>
              <td>
                  <p><?php echo $person['id'] ?></p>
              </td>
              <td>
                  <input class="border rounded" type="text" name="kullanici_adi" value="<?php echo $person['kullanici_adi']?>">
              </td>
              <td>
                  <input class="border rounded" type="text" name="sifre" value="<?php echo $person['sifre'] ?>">
              </td>
              <td>
                  <select name="tur">
                    <option value="admin" <?php echo $person['tur'] === "admin" ? "selected" : ""?>>admin</option>
                    <option value="yonetici" <?php echo $person['tur'] === "yonetici" ? "selected" : ""?>>yonetici</option>
                    <option value="musteri" <?php echo $person['tur'] === "musteri" ? "selected" : ""?>>musteri</option>
                  </select>
              </td>
              <td>
                  <input type="hidden" value="<?php echo $person['id'] ?>" name="id">
                  <button class="bg-blue-400 rounded p-1" name="duzenle">Düzenle</button>
              </td>
            </tr>
            </form>
            <?php } ?>
      </table>
    </div>
  </body>
</html>