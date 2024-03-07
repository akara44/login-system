    <?php
    class helper{
      static function yonlendir($url, $sure=0){
          if ($sure != 0) {
            header("Refresh: $sure; url = $url");
          }
          else {
            header("Location: $url");
          }
      }
    }
    
  ?>