<?php 
  include "nav.php";
  require_once "session.php";
  require_once "db.php";
  $restaurantlar = $db->query("SELECT restaurant_id FROM restaurant WHERE sahip = " . $_SESSION['id'])->fetchAll();
?>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body>
    <div class="container flex mx-auto flex-col gap-4">
      <div class="border-b pb-4">
        <div class="flex items-center justify-center gap-6 mt-4">
          <a class="border rounded p-1 hover:bg-neutral-200" href="yonetimEkle.php">Restoran Ekle</a>
          <a class="border rounded p-1 hover:bg-neutral-200" href="yonetimMenu.php">Restoran Menü Ekle </a>
        </div>
      </div>
      
      <table class="min-w-full m-4">
        <tr class="font-bold">
          <td>siparis id</td>
          <td>restaurant</td>
          <td>menuler</td>
          <td>tutar</td>
          <td>zaman</td>
          <td>kullanici</td>
          <td>İşlemler</td>
        </tr>
        <?php foreach($restaurantlar as $restaurant) { ?>
          <?php $siparisler = $db->query("SELECT * FROM siparisler INNER JOIN restaurant ON restaurant.restaurant_id = siparisler.restaurant_id WHERE siparisler.restaurant_id = {$restaurant['restaurant_id']}") ?>

          <?php foreach($siparisler as $siparis) { ?>
            <?php $kullanici = $db->query("SELECT * FROM kullanicilar WHERE id = {$siparis['kullanici_id']}")->fetch() ?>
            <?php $menuler = $db->query("SELECT isim FROM menuler WHERE menu_id IN ({$siparis['menuler']})")->fetchAll() ?>
            <tr>
              <td><?php echo $siparis['siparis_id'] ?></td>
              <td><?php echo "{$siparis['isim']}({$restaurant['restaurant_id']})" ?></td>
              <td><?php echo implode(",", array_column($menuler,'isim')) ?></td>
              <td><?php echo $siparis['tutar'] ?> TL</td>
              <td><?php echo $siparis['zaman'] ?></td>
              <td><?php echo $kullanici['kullanici_adi'] ?></td> 
              <?php if($siparis['durum'] == 0) { ?>
                <form action="" method="POST">
                  <input type="hidden" name="siparis" value="<?php echo $siparis['siparis_id']?>">
                  <td>
                    <button class="border rounded px-12 hover:bg-green-400" name="islem" value="onayla">Onayla</button>
                    <button class="border rounded px-12 hover:bg-red-400" name="islem" value="iptal">Iptal</button>
                  </td>
                </form>
              <?php } else if ($siparis['durum'] == 1) { ?>
                <td>Onaylandı</td>
              <?php } else if ($siparis['durum'] == 2) { ?>
                <td>Reddedildi</td>
              <?php } ?>
            </tr>
        <?php }} ?>
      </table>
    </div>
  </body>
</html>

<?php 
  if(!isset($_POST['siparis']) || 
     !isset($_POST['islem'])) {
    return;
  }
  
  $siparisId = $_POST['siparis'];
  $islem = $_POST['islem'];
  $siparis = $db->query("SELECT * FROM siparisler INNER JOIN restaurant ON restaurant.restaurant_id = siparisler.restaurant_id WHERE siparis_id = '$siparisId'")->fetch();

  if($siparis['durum'] != 0) {
    return;
  }

  if($islem == 'onayla'){
    $db->query("UPDATE siparisler SET durum=1 WHERE siparis_id = '$siparisId'");
    $db->exec("UPDATE kullanicilar SET cuzdan = cuzdan + {$siparis['tutar']} WHERE id = {$siparis['sahip']}");
  }

  if($islem == 'iptal'){
    $db->exec("UPDATE siparisler SET durum=2 WHERE siparis_id = '$siparisId'");
    $db->exec("UPDATE kullanicilar SET cuzdan = cuzdan + {$siparis['tutar']} WHERE id = (SELECT kullanici_id FROM siparisler WHERE siparis_id = '$siparisId')");
  }
?>