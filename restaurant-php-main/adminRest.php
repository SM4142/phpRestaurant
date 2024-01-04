<html>
  <head>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body>
    
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
    header("Location: adminRest.php");
  }

  if(isset($_POST['sil'])){
    $id = $_POST['id'];
    $sil= $db->exec("DELETE FROM restaurant WHERE restaurant_id='$id'");
    header("Location: adminRest.php");
  }
?>
<div class="container flex mx-auto">
  <table border="1" class="min-w-full m-4">
      <tr class="border-b font-bold">
          <td>
              Resturant Adı
          </td>
          <td>
              İletişim
          </td>
          <td>
              Adres
          </td>
        <?php if (!isset($_POST['guncel'])) { ?>
          <td>
              Sahip Adı
          </td>
          <td>
              Sahip Id
          </td>
        <?php } ?>
          <td>
              İşlemler
          </td>
      </tr>
      <?php if (!isset($_POST['guncel'])) { ?>
      <?php foreach ($restaurantlar as $rest =>$key) : ?>
        <tr class="border-b">
            <td>
              <?php echo $key['isim'] ?>
            </td>
            <td>
              <?php echo $key['iletisim'] ?>
            </td>
            <td>
              <?php echo $key['adres'] ?>
            </td>
            <td>
              <?php echo $key['kullanici_adi'] ?>
            </td>
            <td>
              <?php echo $key['id'] ?>
            </td>
            <td>
              <form method="POST" class="flex items-center my-auto gap-4">
                <input type="hidden" name="id" value="<?php echo $key['restaurant_id'] ?>">    
                <button class="bg-red-400 px-4 rounded p-1" name="sil">Sil</button>
                <button class="bg-blue-400 rounded p-1" name="guncel">Düzenle</button>
              </form>
            </td>
        </tr>
      <?php endforeach; ?>
      <?php } else { ?>
        <?php
        $id = $_POST['id'];
        $duzen = $db->query("SELECT * from restaurant WHERE restaurant_id='$id'")->fetch();

        ?>
        <form method="POST" action="guncelle.php">
          <tr>
            <td>
              <input class="border rounded" type="text" name="isim1" value="<?php echo $duzen['isim'] ?>">
            </td>
            <td>
              <input class="border rounded" type="text" name="iletisim1" value="<?php echo $duzen['iletisim'] ?>">
            </td>
            <td>
              <input class="border rounded" type="text" name="adres1" value="<?php echo $duzen['adres']  ?>">
            </td>
            <td>

              <input type="hidden" name="id1" value="<?php echo $duzen['restaurant_id'] ?>">
              <button class="bg-blue-400 rounded p-1" name='duzenle'>Kaydet</button>

            </td>
          </tr>
        </form>
      <?php  } ?>
    </table>
    </div>
  </body>
</html>