<?php

namespace App\Libraries;

class Hash
{
    public static function hashpassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    public static function verifypassword($password, $dbpassword)
    {
        // $hash = '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjXl.0t1XkA8pw9dMXTpOq';
       // $hash = $dbpassword;
      //  if (password_verify($password, $hash)) {
     //       return true;
     //   } else {
      //      return false;
      //  }
         return password_verify($password, $dbpassword);
    }
}
