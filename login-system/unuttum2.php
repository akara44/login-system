<?php
require_once "config/baglanti.php";
require_once "template/header.php";
require_once "template/footer.php";
?>
<?php

if ($_POST) {
   $email = strip_tags($_POST['email']);
   $sifre = strip_tags($_POST['sifre']);
   $sifretekrar = strip_tags($_POST['sifretekrar']);
   $kod = strip_tags($_POST['kod']);
   if ($email != "" and $sifre != "" and $sifretekrar != "" and $kod != "") {
    if ($sifre == $sifretekrar) {
        $control = $baglanti->db->prepare("SELECT * FROM kullanici WHERE unuttum = ? and email = ?");
        $control->execute(array($kod, $email));
        $sonuc = $control->rowCount();
        if ($sonuc != 0) {
            $sorgu = $baglanti->db->prepare("UPDATE kullanici set sifre = ? , unuttum = ? where email = ?");
            $calistir = $sorgu->execute(array(md5($sifre),"",$email));
            if ($calistir) {
                // echo "İşleminiz Başarılı Bir Şekilde Gerçekleşti";
                echo '<script>
                Swal.fire({
                  title: "İşleminiz Gerçekleşti!",
                  text: "İşleminiz Başarılı Bir Şekilde Gerçekleşti",
                  icon: "success",
                  confirmButtonText: "Tamam"
                });
              </script>';
                helper::yonlendir(SITE_URL,3);
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
        else {
            // echo "İşleminiz Gerçekleştirilemedi.Girdiğiniz Kod Yanlış";
            echo '<script>
            Swal.fire({
              title: "Kod Yanlış!",
              text: "İşleminiz Gerçekleştirilemedi.Girdiğiniz Kod Yanlış",
              icon: "error",
              confirmButtonText: "Tamam"
            });
          </script>';
        }

    }
    else {
        // echo "Şifreleriniz Uyuşmamaktadır";
        echo '<script>
    Swal.fire({
      title: "Şifreleriniz Uyuşmamaktadır!",
      text: "Girdiğiniz Şifreler Uyuşmamaktadır Lütfen Tekrar Deneyin",
      icon: "error",
      confirmButtonText: "Tamam"
    });
  </script>';
    }
   }
   else {
    // echo "Lütfem Tüm Alanlarıu Doldurunuz";
    echo '<script>
    Swal.fire({
      title: "Tüm Alanları Doldurun!",
      text: "Lütfen Tüm Alanları Doldurun",
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
  background: url(public/img/bg.jpg) no-repeat;
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
</style>

  <div class="wrapper">
    <form action="" method="POST">
      <h1>Şifreyi Yenile</h1>
      <div class="input-box">
        <input type="text" placeholder="Email" name="email">
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="text" placeholder="Kodu Giriniz" name="kod">
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <div class="input-box">
        <input type="password" placeholder="Yeni Şifre" name="sifre">
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <div class="input-box">
        <input type="password" placeholder="Yeni Şifrenizi Tekrar Giriniz" name="sifretekrar">
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <button type="submit" class="btn">Onayla</button>
      <div class="register-link">
      </div>
    </form>
  </div>

 <!-- <form action="" method="POST">
  <div class="form">
       <span>email</span>
         <input type="email" name="email">
     </div>
     <div class="form">
       <span>Tek Kullanımlık kod</span>
         <input type="text" name="kod">
     </div>
     <div class="form">
       <span>Yeni Şifrenizi Girin</span>
         <input type="text" name="sifre">
     </div>
     <div class="form">
       <span>Yeni Şifrenizi Tekrar Girin</span>
         <input type="text" name="sifretekrar">
     </div>
     <div class="form">
        <button>Giriş Yap</button>
    </div> -->