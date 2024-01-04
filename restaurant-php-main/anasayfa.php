<?php
  include "nav.php";
  require_once "db.php";
  $resturantlar = $db->query("SELECT * FROM restaurant");
?>

<html>
  <head>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body>
    <div class="flex container mx-auto gap-6 my-4 flex-wrap">
      <?php foreach($resturantlar as $restaurant) { ?>
        <a class="border rounded hover:bg-neutral-200" href=<?php echo "restaurant.php?id=".$restaurant["restaurant_id"] ?>>
          <div class="p-2">
            <img width="200px" height="200px" class="w-[200px] h-[200px]" src="<?php echo $restaurant["foto"] ?>">
            <div class="relative">
              <?php $puan = $db->query("SELECT ROUND(AVG(puan),2) FROM yorumlar WHERE restaurant_id = $restaurant[restaurant_id]")->fetch()[0]; ?>
              <p class="font-bold block text-center"><?php echo $restaurant["isim"] ?> <span class="text-sm">(<?php echo $puan ? $puan : 0 ?> puan)</span></p>
              <p><?php echo $restaurant["adres"] ?></p>
            </div>
          </div>
        </a>
      <?php } ?>
    </div>
  </body>
</html>