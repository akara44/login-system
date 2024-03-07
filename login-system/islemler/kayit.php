<?php
require_once "../config/baglanti.php";
require_once "../template/header.php";
require_once "../template/footer.php";

?>
<?php
if ($_POST) {
    $isim = strip_tags($_POST["isim"]);
    $soyisim = strip_tags($_POST["soyisim"]);
    $email = strip_tags($_POST["email"]);
    $sifre = strip_tags($_POST["sifre"]);
    $cinsiyet = intval($_POST["cinsiyet"]);
    if ($isim != "" and $soyisim != "" and $email != "" and $sifre != "") {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $tarih = date("Y-m-d");
           $control =$baglanti->db->prepare("SELECT * FROM kullanici WHERE email = :email");
           $control->bindParam(":email", $email, PDO::PARAM_STR);
           $control->execute();
           $sayi = $control->rowCount();
           if ($sayi == 0) {
            $sorgu = $baglanti->db->prepare("INSERT INTO kullanici(isim,soyisim,email,sifre,cinsiyet,kayit_tarihi) VALUES(?,?,?,?,?,?)");      
            $ekle = $sorgu->execute(array($isim, $soyisim, $email, md5($sifre), $cinsiyet, $tarih));
            if ($ekle) {
                $dizi = ["email"=>$email,"sifre"=>md5($sifre)];
                sessionManager::sessionOlustur($dizi);
                helper::yonlendir("http://localhost/LOGIN-SYSTEM/");

            }else {
                // echo "Kayıt Başrısız";
                echo '<script>
                Swal.fire({
                  title: "Kayıt Başarısız!",
                  text: "Kayıt Başarısız Lütfen Tekrar Deneyin",
                  icon: "error",
                  confirmButtonText: "Tamam"
                });
              </script>';
            }
        }
           else {
            // echo "Bu Kullanıcı Veritabanında Mevcut";
            echo '<script>
            Swal.fire({
              title: "Kullanıcı Mevcut!",
              text: "Bu Kullanıcı Sistemimizde Mevcut",
              icon: "error",
              confirmButtonText: "Tamam"
            });
          </script>';
           }
        }
        else {
            // echo "Email Formatı Yanlış";
            echo '<script>
            Swal.fire({
              title: "Email Formatı Yanlış!",
              text: "Lütfen Email Formatına Uygun Bir Değer Giriniz",
              icon: "error",
              confirmButtonText: "Tamam"
            });
          </script>';
        }
    }
    else {
        // echo "Lütfen Tüm Değerleri Eksizsiz Girin";
        echo '<script>
        Swal.fire({
          title: "Boş Alan!",
          text: "Lütfen Tüm Değerleri Eksizsiz Girin",
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
      <h1>Kayıt Ol</h1>
      <div class="input-box">
        <input type="text" placeholder="İsim"  name="isim">
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="text" placeholder="Soyisim" name="soyisim">
        <i class='bx bxs-user' ></i>
      </div>
      <div class="input-box">
        <input type="text" placeholder="Email" name="email">
        <i class='bx bx-envelope'></i>
      </div>
      <div class="input-box">
        <input type="password" placeholder="Şifre" name="sifre">
        <i class='bx bxs-lock-alt'></i>
      
      </div>
      <div class="register-link">
        <span>Cinsiyet</span>
        <select name="cinsiyet">
            <option value="0">Bay</option>
            <option value="1">Bayan</option>
        </select>
    </div>
      <button type="submit" class="btn">Kayıt Ol</button>
      <div class="register-link">
      </div>
    </form>
  </div>

<!-- <form action="" method="POST">
    <div class="form">
        <span>İsim</span>
        <input type="text" name="isim">
    </div>
    <div class="form">
        <span>Soyisim</span>
        <input type="text" name="soyisim">
    </div>
    <div class="form">
        <span>E-mail</span>
        <input type="email" name="email">
    </div>
    <div class="form">
        <span>Şifre</span>
        <input type="password" name="sifre">
    </div>
    <div class="form">
        <span>Cinsiyet</span>
        <select name="cinsiyet">
            <option value="0">Bay</option>
            <option value="1">Bayan</option>
        </select>
    </div>
    <div class="form">
        <button>Kayıt Ol</button>
    </div>

</form> -->