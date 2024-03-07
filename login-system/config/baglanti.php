<?php
session_start();
class baglanti{
    public $db;
    function __construct(){
        $this->db = new PDO("mysql:host=localhost;dbname=kutuphane;charset=utf8","root","");
        
    }
}
define("SITE_URL", "http://localhost/LOGIN-SYSTEM/");

require_once "sessionManager.php";
require_once "helper.php";
$baglanti = new baglanti();
$sessionManager = new sessionManager();

?>