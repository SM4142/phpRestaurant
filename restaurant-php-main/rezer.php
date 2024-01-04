<?php 
  include "nav.php";
  require_once "session.php";
  require_once "db.php";
  if(!isset($_SESSION['id'])){
    return;
  }
  $id = $_SESSION['id'];
  $rezer = $db -> query("SELECT siparis_id,menuler,tutar,zaman,durum,isim FROM siparisler si inner join restaurant re on si.restaurant_id = re.restaurant_id Where kullanici_id = '$id'")->fetchAll();

?>
<html>
    
    <body>
        <script src="https://cdn.tailwindcss.com"></script>
        <div class="container flex mx-auto flex-col gap-4">
        <table class="min-w-full m-4">
            <tr class="font-bold">
                <th>
                    Sipariş No
                </th>
                <th>
                    Menüler 
                </th>
                <th>
                    Tutar 
                </th>
                <th>
                    Zaman
                </th>
                <th>
                    Restoran Adı
                </th>
                <th>
                    Durum
                </th>
            </tr>
            <?php if( $db -> query("SELECT siparis_id,menuler,tutar,zaman,durum,isim FROM siparisler si inner join restaurant re  on si.restaurant_id =re.restaurant_id   Where kullanici_id = '$id'")->fetchColumn() >0) { ?>
                <?php foreach($rezer as $key) { ?>
                    <tr>
                        <td>
                            <?php echo $key['siparis_id'] ?>
                        </td>
                        <td>
                            <?php echo $key['menuler'] ?>
                        </td>
                        <td>
                            <?php echo $key['tutar'] ?>
                        </td>
                        <td>
                            <?php echo $key['zaman'] ?>
                        </td>
                        <td>
                            <?php echo $key['isim'] ?>
                        </td>
                        <td>
                            <?php if($key['durum']==0) { ?>
                            Beklemede
                            <?php } elseif($key['durum']==1) { ?>
                            Onaylandı
                            <?php } else { ?>
                            İptal Edildi
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </table>
        </div>
        
    </body>
</html>