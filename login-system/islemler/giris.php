<?php
require_once "../config/baglanti.php";
require_once "../template/header.php";
require_once "../template/footer.php";

?>
<!-- <h3>Giriş Yap</h3> -->

<?php
if (isset($_COOKIE['giris'])) {
    $json = json_decode($_COOKIE['giris'], true);
    sessionManager::sessionOlustur($json);
    //  helper::yonlendir(SITE_URL);
}
if ($_POST) {
    $hatirla = @intval($_POST['hatirla']);
    $email = strip_tags($_POST['email']);
    $sifre = strip_tags($_POST['sifre']);
    if ($email != "" and $sifre != "") {
        $sifre = md5($sifre); 
        $sorgu = $baglanti->db->prepare("SELECT * FROM kullanici where email = :email and sifre = :sifre");
        $sorgu->bindParam(":email",$email, PDO::PARAM_STR);
        $sorgu->bindParam(":sifre",$sifre, PDO::PARAM_STR);
        $sorgu->execute();
        $sayi = $sorgu ->rowCount();
        if ($sayi == 0 ) {
            // echo "Bu Bilgilere Göre Kullanıcı Bulunamadı";
            echo '<script>
            Swal.fire({
              title: "Kullanıcı Yok!",
              text: "Bu Bilgilere Göre Kullanıcı Bulunamadı",
              icon: "error",
              confirmButtonText: "Tamam"
            });
          </script>';
        }
        else {
            if ($hatirla == 1) {
                $cookieArray = array("email"=>$email, "sifre"=>$sifre);
                $cookieArray = json_encode($cookieArray);
                setcookie("giris" ,$cookieArray  ,time()+36000, '/');
            }
            sessionManager::sessionOlustur(array("email"=>$email, "sifre"=>$sifre));
            helper::yonlendir(SITE_URL);
        }
    }
    else{
        // echo "Lütfen Tüm Alanları Doldurunuz";
        echo '<script>
        Swal.fire({
          title: "Onaylanmadı!",
          text: "Lütfen Tüm Alanları Doldurunuz",
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
  background: url(../public/img/bg.jpg) no-repeat;
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
      <h1>Giriş Yap</h1>
      <div class="input-box">
        <input type="text" placeholder="Email" name="email">
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="password" placeholder="Şifre" name="sifre">
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <div class="remember-forgot">
        <label><input type="checkbox" name="hatirla" value="1">Beni Hatırla</label>
        <a href="../unuttum.php">Şifremi Unuttum</a>
      </div>
      <button type="submit" class="btn">Giriş</button>
      <div class="register-link">
        <p>Hesabınız Yokmu?<a href="../islemler/kayit.php">Kayıt Ol</a></p>
      </div>
    </form>
  </div>



<!-- <form action="" method="POST">
    <div class="form">
        <span>email</span>
        <input type="text" name="email">
    </div>
    <div class="form">
        <span>Şifre</span>
        <input type="password" name="sifre">
    </div>
    <div class="form">
        <span>Beni Hatırla</span>
        <input type="checkbox" name="hatirla" value="1">
    </div>
    <div class="form">
        <button>Giriş Yap</button>
    </div>
    <a class="link" href="../islemler/kayit.php">Kayıt Ol</a>
    <a class="link" href="../unuttum.php">Şifremi Unuttum</a> -->