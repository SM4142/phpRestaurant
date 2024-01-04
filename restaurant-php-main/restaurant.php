<?php
  include "nav.php";
  require_once "db.php";
  require_once "session.php";

  if(!isset($_GET['id']) || empty($_GET['id']))
  {
    header("Location: anasayfa.php");
    return;
  }
  
  $id = $_GET['id'];
  $restaurant = $db->query("SELECT * FROM restaurant WHERE restaurant_id = $id")->fetch();
  $yorumlar = $db->query("SELECT * FROM yorumlar INNER JOIN kullanicilar ON yorumlar.kullanici_id = kullanicilar.id WHERE restaurant_id = $id")->fetchAll();
  $puan = $db->query("SELECT ROUND(AVG(puan),2) FROM yorumlar WHERE restaurant_id = $id")->fetch()[0];
?>  

<html>      
  <head>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body>
    <div class="container mx-auto pb-12">
      <p class="text-3xl text-center"><?php echo $restaurant['isim']; ?> <span class="text-sm">(<?php echo $puan ? $puan : 0; ?> Puan)</span></p>
      <p><span class="text-lg">Iletisim: </span><?php echo $restaurant['iletisim']; ?></p>
      <p><span class="text-lg">Adres: </span><?php echo $restaurant['adres']; ?></p>
      <?php if($restaurant['cocuk_parki']== 1 )  : ?>
      <p><span class="text-lg">Çocuk Parkı Var </span></p>
      <?php endif ; ?>
      <img class="mx-auto" width="500px" height="500px" src="<?php echo $restaurant["foto"] ?>">
      <div class="w-[720px] mx-auto">
        
      <p class="text-center text-xl font-bold mt-6">MENÜLER</p>
      <?php $menuler = $db->query("SELECT * FROM menuler WHERE restaurant_id=$id"); ?>
      <?php if($menuler->rowCount() > 1) { ?>
        <form method="post" action="siparis.php">
        <div class="flex flex-wrap gap-4 overflow-x-auto snap-x my-4 border-b pb-6 ">
          <?php foreach($menuler as $menu) { ?>
            <div class="flex flex-col border rounded w-fit ">
              <img height="150px" width="150px" src="<?php echo $menu['foto'] ?>"></img>
              <div class="p-1">
                <p class=""><?php echo $menu['isim']; ?></p>
                <p class="text-sm"><?php echo $menu['fiyat']; ?> TL</p>
                  <input type="checkbox" value="<?php echo $menu['menu_id'] ?>" name="menu[]">
                </div>
              </div> 
              <?php } ?>
            </div>
            <?php if(isset($_SESSION['id'])) { ?>
              <button class="border rounded px-12 hover:bg-neutral-200" name="siparis">Siparis et</button>
              <input type="hidden" name="restaurant_id" value="<?php echo $id ?>">
            <?php } ?>
          </form>
        <?php } ?>

        <?php if(isset($_SESSION['id']) && $_SESSION['id'] != "") { ?>
          <form method="post" class="flex flex-col gap-2 py-2">
            <div class="flex gap-2">
              Puaniniz:
              <select name="puan" class="w-16">
                <option value="5" >5</option>
                <option value="4" >4</option>
                <option value="3" >3</option>
                <option value="2" >2</option>
                <option value="1" >1</option>
              </select>
            </div>
            <textarea name="yorum" cols="20" rows="5" class="border text-sm"></textarea>
            <button name="yap" class="border rounded px-12 hover:bg-neutral-200">Yorum yap</button>
          </form>
          <?php } ?> 

        <p class="text-center text-2xl mt-24 mb-4">Diğerleri ne düşünüyor??</p>
        <?php foreach($yorumlar as $yorum) { ?>
          <div>
            <p class="text-neutral-500 inline"><?php echo $yorum['kullanici_adi'] ?>:</p>
            <p class="inline text-sm text-neutral-400">(<?php echo $yorum['puan'] ?> puan)</p>
            <p class="inline"><?php echo $yorum['yorum']; ?></p>
          </div>
        <?php } ?>
      </div>
    </div>
  </body>
</html>
              
<?php
  require_once "db.php";

  if($_SERVER['REQUEST_METHOD'] != "POST" || !isset($_POST['yap']))
    return;

  $yorum = $_POST['yorum'];
  $puan = $_POST['puan'];
  $kullaniciId = $_SESSION['id'];

  $db->exec("INSERT INTO yorumlar (yorum, kullanici_id, restaurant_id, puan) VALUES ('$yorum', '$kullaniciId', '$id', '$puan') ON DUPLICATE KEY UPDATE yorum = '$yorum', puan = '$puan'");
  header("Location: restaurant.php?id=$id");
?>