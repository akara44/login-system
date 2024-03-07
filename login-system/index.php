<?php
require_once 'config/baglanti.php';
require_once 'template/header.php';



if (!$sessionManager->kontrol()){
    helper::yonlendir("/LOGIN-SYSTEM/islemler/giris.php");
    die();
}
$kBilgi = $sessionManager->kullaniciBilgi();


?>
<style>
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}
body{
  min-height: 100vh;
  background: url(public/img/bg.jpg) no-repeat;
  background-size: cover;
  background-position: center;
}

.title{
    color: white;

}
.link{
color: white;
}
</style>

<div class="info"></div>

<div class="title">Merhaba<?php echo $kBilgi['isim']; ?></div> 
<div class="title">Soyisim:<?php echo $kBilgi['soyisim']; ?></div>
<div class="title">Mail:<?php echo $kBilgi['email']; ?></div> 
<div class="title">Kayıt Tarihi<?php echo $kBilgi['kayit_tarihi']; ?></div> 
<div class="title">Cinsiyet<?php echo $kBilgi['cinsiyet']; ?></div> 

<a href="islemler/cikis.php" class="link">Çıkış</a>


<?php
require_once 'template/footer.php';
?>

