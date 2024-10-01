<?php
namespace App\Libraries;

class Hash
{
    public static function encrypt_password($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
    // İlki formdan gelen şifre 
    // ikinci de veritabanından gelen şifre
    public static function verify_password($password, $hashed_password)
    {
        return password_verify($password, $hashed_password);
    }
}
?>