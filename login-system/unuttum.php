<?php
require_once "config/baglanti.php";
require_once "template/header.php";
require_once "template/footer.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
?>
<?php

if ($_POST) {
   $email = strip_tags($_POST['email']);
   if ($email != "") {
        $control = $baglanti->db->prepare("SELECT * FROM kullanici WHERE email = :email");
        $control->bindParam("email", $email, PDO::PARAM_STR);
        $control->execute();
        $sonuc = $control->rowCount();
        if ($sonuc != 0) {
            $kod = rand(1,9000)."-".rand(1,9000);
            $sorgu = $baglanti->db->prepare("UPDATE kullanici set unuttum = ? WHERE email = ?");
            $calis = $sorgu->execute(array($kod, $email));
            if ($calis){
                $mesaj = "Merhaba Şifrenizi Alttaki Kodu Kullanarak Yenileyebilirsiniz
                                     Tek Kullanımlık Kodun:.$kod
                                 LÜTFEN KODUNUZU KİMSEYLE Paylaşmayın";
               
            
                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    $mail->SMTPAuth=true;
                    $mail->SMTPSecure="tls";// ssl
                    $mail->Port = 587;
                    $mail->Host = "smtp.gmail.com";
                    $mail->Username = "Buraya Kendi Emailinizi Girin";
                    $mail->Password = "Buraya 2 adımlı doğrulamanın size vermiş olduğu şifreyi girin";
                    $mail->addAddress($email);
                    $mail->Subject = "Şifrenizi Yenileyin";
                    $mail->Body = $mesaj;
                    if ($mail->Send()) {
                      // echo  "Mailinize Kod Gönderildi";
                      echo '<script>
                        Swal.fire({
                          title: "Mailinize Kod Gönderildi!",
                          text: "Lütfen Mailinizi Kontrol Edin",
                          icon: "success",
                          confirmButtonText: "Tamam"
                        });
                      </script>';
                      
                      helper::yonlendir("http://localhost/K%C3%9CT%C3%9CPHANE-OTOMASYON/unuttum2.php",3);
                    }
                    else {
                        // echo "İşleminiz Gerçekleştirilemedi";
                        echo '<script>
                        Swal.fire({
                          title: "İşleminiz Gerçekleştirilemedi!",
                          text: "İşleminiz Gerçekleştirilemedi Lütfen Tekrar Deneyiniz",
                          icon: "error",
                          confirmButtonText: "Tamam"
                        });
                      </script>';
                        
                    }
            }

        }
        else {
            // echo "Sistemde Böyle Bir Kullanıcı Bulunamadı";
            echo '<script>
            Swal.fire({
              title: "Kullanıcı Sisteme Kayıtlı Değil!",
              text: "Sistemde Böyle Bir Kullanıcı Bulunamadı Lütfen Tekrar Deneyiniz",
              icon: "error",
              confirmButtonText: "Tamam"
            });
          </script>';
        }

   }
   else {
    // echo "Lütfen Bir Email Giriniz";
    echo '<script>
    Swal.fire({
      title: "Bu Alan Boş Bırakılmaz!",
      text: "Lütfen Bir Email Giriniz Bu alan Boş Bırakılmaz",
      icon: "error",
      confirmButtonText: "Tamam"
    });
  </script>';
   }
}
 ?>
    <style>
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}
body{
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background: url("public/img/bg.jpg") no-repeat;
  background-size: cover;
  background-position: center;
}
.wrapper{
  width: 420px;
  background: transparent;
  border: 2px solid rgba(255, 255, 255, .2);
  backdrop-filter: blur(9px);
  color: #fff;
  border-radius: 12px;
  padding: 30px 40px;
}
.wrapper h1{
  font-size: 36px;
  text-align: center;
}
.wrapper .input-box{
  position: relative;
  width: 100%;
  height: 50px;
  
  margin: 30px 0;
}
.input-box input{
  width: 100%;
  height: 100%;
  background: transparent;
  border: none;
  outline: none;
  border: 2px solid rgba(255, 255, 255, .2);
  border-radius: 40px;
  font-size: 16px;
  color: #fff;
  padding: 20px 45px 20px 20px;
}
.input-box input::placeholder{
  color: #fff;
}
.input-box i{
  position: absolute;
  right: 20px;
  top: 30%;
  transform: translate(-50%);
  font-size: 20px;

}
.wrapper .remember-forgot{
  display: flex;
  justify-content: space-between;
  font-size: 14.5px;
  margin: -15px 0 15px;
}
.remember-forgot label input{
  accent-color: #fff;
  margin-right: 3px;

}
.remember-forgot a{
  color: #fff;
  text-decoration: none;

}
.remember-forgot a:hover{
  text-decoration: underline;
}
.wrapper .btn{
  width: 100%;
  height: 45px;
  background: #fff;
  border: none;
  outline: none;
  border-radius: 40px;
  box-shadow: 0 0 10px rgba(0, 0, 0, .1);
  cursor: pointer;
  font-size: 16px;
  color: #333;
  font-weight: 600;
}
.wrapper .register-link{
  font-size: 14.5px;
  text-align: center;
  margin: 20px 0 15px;

}
.register-link p a{
  color: #fff;
  text-decoration: none;
  font-weight: 600;
}
.register-link p a:hover{
  text-decoration: underline;
}
select{
background-color: lightgreen;
width: 140px;
border: none;
}
option{
    border: none;
}   
</style>
    
  <div class="wrapper">
    <form action="" method="POST">
      <h1>Şifremi Unuttum</h1>
      <div class="input-box">
        <input type="text" placeholder="Email" name="email">
        <i class='bx bxs-user'></i>
      </div>
      <button type="submit" class="btn">Kodu Gönder</button>
      <div class="register-link">
      </div>
    </form>
  </div>