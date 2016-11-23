<?php

namespace App;

use Exception;

class UIHelper{
    public static function formatTitle($title){
        if(is_numeric($title)){
            switch($title){
              // 0,2 is male - 1,3 is female - 4 shouldn't really be defined:
              case 0:
                return 'ด.ช.';
              break;
              case 1:
                return 'ด.ญ.';
              break;
              case 2:
                return 'นาย';
              break;
              case 3:
                return 'นางสาว';
              break;
              default:
                throw new \Exception("What the gender?");
            }
        }else{
            return $title;
        }
    }
}
