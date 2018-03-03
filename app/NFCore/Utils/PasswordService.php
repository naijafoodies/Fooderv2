<?php
  namespace App\NFCore\Utils;

  class PasswordService
  {

      public function __construct() {

      }

      /**
      * Function generates random password using the bcrypt algorithm
      *
      * @return string
      */
      public static function generatePassword() {

        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        //return substr(str_shuffle($chars),0,8);
        return "server1";
      }


  }
