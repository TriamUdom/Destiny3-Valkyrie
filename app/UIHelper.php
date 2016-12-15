<?php

namespace App;

use Exception;

class UIHelper{
    public static function formatTitle($title, $langague = 'tha'){
        if(is_numeric($title)){
            switch($title){
              // 0,2 is male - 1,3 is female - 4 shouldn't really be defined:
                case 0:
                    if($langague == 'eng'){
                        return 'Mr.';
                    }

                    return 'ด.ช.';
                break;
                case 1:
                    if($langague == 'eng'){
                        return 'Ms.';
                    }

                    return 'ด.ญ.';
                break;
                case 2:
                    if($langague == 'eng'){
                        return 'Mr.';
                    }

                    return 'นาย';
                break;
                case 3:
                    if($langague == 'eng'){
                        return 'Ms.';
                    }

                    return 'นางสาว';
                break;
                default:
                    throw new \Exception("What the gender?");
                break;
            }
        }else{
            return $title;
        }
    }
}
