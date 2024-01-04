<?php
  include "nav.php";
  require_once "session.php";
  require_once "db.php";
  if(isset($_POST['menuEkle'])){
    $id = $_POST['id'];
    $isim = $_POST['isim'];
    $fiyat = $_POST['fiyat'];
    $gorsel = $_FILES['gorsel'];
    $fileName = $gorsel['name'];
    $filePath = "./files/".md5(time()).$fileName;
    move_uploaded_file($gorsel['tmp_name'], $filePath);
    $db->query("INSERT INTO menuler (restaurant_id, isim, fiyat, foto) VALUES ('$id', '$isim', '$fiyat', '".$filePath. "')");
  }
?>

<html>
  <head>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body>
    <form method="POST" class="mx-auto flex flex-col w-fit mt-4 gap-2" enctype="multipart/form-data">
      <label for="id">Restaurant ismi</label>
      <select name="id" >
        <?php $restaurantlar = $db->query("SELECT * FROM restaurant WHERE sahip = $_SESSION[id]") ?>
        <?php foreach($restaurantlar as $rest) { ?>
          <option value="<?php echo $rest['restaurant_id'] ?>">
            <?php echo $rest['isim'] ?>
          </option>
        <?php } ?>
      </select>
      <input type="text" name="isim" placeholder="menu ismi">
      <input type="number" name="fiyat" placeholder="12">
      <input type="file" name="gorsel">
      <button name="menuEkle">Ekle</button>
    </form>
  </body>
</html>