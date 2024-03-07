<?php
class sessionManager extends baglanti{
static function sessionOlustur($array = []){
      if (count($array) != 0) {
        
             foreach ($array as $key => $value) {
                    $_SESSION[$key] = $value;
                }
            }
         }
         static function sessionSil(){
                session_destroy();
         }
         public function kontrol() {
        if (isset(($_SESSION['email'])) and isset(($_SESSION['sifre']))) {
            $email = strip_tags($_SESSION['email']);
            $sifre = strip_tags($_SESSION['sifre']);
            $control = $this->db->prepare("SELECT * FROM kullanici WHERE email = :email and sifre = :sifre");
            $control->bindParam(":email",$email, PDO::PARAM_STR);
            $control->bindParam(":sifre",$sifre, PDO::PARAM_STR);
            $control->execute();
            $sayi = $control->rowCount();
            if ($sayi == 0) {
                return false;
            }
            else{
                return true;
            }
            
        }else {
            return false;
        }
            
         }
         public function kullaniciBilgi(){
             if ($this->kontrol()) {
                $sorgu = $this->db->prepare("SELECT *FROM kullanici WHERE email = :email and sifre =:sifre");
                $sorgu->bindParam(":email",$_SESSION['email'], PDO::PARAM_STR);
                $sorgu->bindParam(":sifre",$_SESSION['sifre'], PDO::PARAM_STR);
                $sorgu->execute();
                return $sorgu->fetch(PDO::FETCH_ASSOC);
             }
             else {
                return false;
             }
         }
    }   
    

?>