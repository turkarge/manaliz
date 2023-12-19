<?php
class VT{
    var $sunucu="localhost";
    var $user="root";
    var $password="";
    var $dbname="manaliz";
    var $baglanti;
    function __construct()
    {
        try {
            $this->baglanti=new PDO("mysql:host=".$this->sunucu.";dbname=".$this->dbname.";charset=utf8",$this->user,$this->password);
        } catch (PDOException $error) {
            echo $error->getMessage();
            exit();
        }
    }
}
?>