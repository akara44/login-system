<?php
require_once('../config/baglanti.php');
if ($sessionManager->kontrol()) {
    print_r($_COOKIE);
    sessionManager::sessionSil();
    setcookie("giris" ,""  ,time()-36000);
    helper::yonlendir("/LOGIN-SYSTEM/islemler/giris.php");

}
else {
    helper::yonlendir("/LOGIN-SYSTEM/islemler/giris.php");
}
?>