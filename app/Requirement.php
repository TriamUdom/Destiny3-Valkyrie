<?php

namespace App;

use Exception;
use Validator;

class Requirement{

    protected $required_grade = [
        '5' => [ // Sci - Math
            'sci_1' => '3.9', // Basic
            'sci_2' => '3.9', // Advance
            'mat_1' => '3.9', // Basic
            'mat_2' => '3.9', // Advance
            'total' => '3.8',
        ],
        '4' => [ // Eng - Math
            'tha_1' => '3.9', // Basic
            'mat_1' => '3.9', // Basic
            'mat_2' => '3.9', // Advance
            'eng_1' => '3.9', // Basic
            'eng_2' => '3.9', // Advance
            'total' => '3.8',
        ],
        '1' => [ // Eng - French
            'tha_1' => '3.9', // Basic
            'eng_1' => '3.9', // Basic
            'eng_2' => '3.9', // Advance
            'soc_1' => '3.9', // Basic
            'total' => '3.8',
        ],
        '2' => [ // Eng - German
            'tha_1' => '3.9', // Basic
            'eng_1' => '3.9', // Basic
            'eng_2' => '3.9', // Advance
            'soc_1' => '3.9', // Basic
            'total' => '3.8',
        ],
        '3' => [ // Eng - Japan
            'tha_1' => '3.9', // Basic
            'eng_1' => '3.9', // Basic
            'eng_2' => '3.9', // Advance
            'soc_1' => '3.9', // Basic
            'total' => '3.8',
        ],
    ];

    public static function verifyGrade($plan, $input_grade, $total_grade){
        if(!isset($this->requried_grade[$plan]){
            throw new Exception('Plan not in array');
        }

        foreach($input_grade as $grade){
            $validator = Validator::make([
                'subject_code' => $grade['code'],
            ], [
                'subject_code' => 'subject_code',
            ]);

            if($validator->fails()){
                throw new Exception('Invalid subject code');
            }

            $splited_code =  str_split($grade['code']);

            $level = ($splited_code[2] == 1) ? 1 : 2; // Is the subject basic or advance

            switch($grade['subject']){
                case 'sci':
                    $sci[$level][] = $grade['grade'];
                break;
                case 'mat':
                    $mat[$level][] = $grade['grade'];
                break;
                case 'eng':
                    $eng[$level][] = $grade['grade'];
                break;
                case 'tha':
                    $tha[$level][] = $grade['grade'];
                break;
                case 'soc':
                    $soc[$level][] = $grade['grade'];
                break;
                default:
                    throw new Exception('Unexpected subject');
                break;
            }
        }

        switch($plan){
            case '1':
                if(self::averageGrade($soc[1]) >= $this->requried_grade[$plan]['soc_1']){
                    return false;
                }
                if(self::averageGrade($tha[1]) >= $this->requried_grade[$plan]['tha_1']){
                    return false;
                }
                if(self::averageGrade($eng[1]) >= $this->requried_grade[$plan]['eng_1']){
                    return false;
                }
                if(self::averageGrade($eng[2]) >= $this->requried_grade[$plan]['eng_2']){
                    return false;
                }

                if($total_grade >= $this->required_grade[$plan]['total_grade']){
                    return false;
                }

                return true;
            break;
            case '2':
                if(self::averageGrade($soc[1]) >= $this->requried_grade[$plan]['soc_1']){
                    return false;
                }
                if(self::averageGrade($tha[1]) >= $this->requried_grade[$plan]['tha_1']){
                    return false;
                }
                if(self::averageGrade($eng[1]) >= $this->requried_grade[$plan]['eng_1']){
                    return false;
                }
                if(self::averageGrade($eng[2]) >= $this->requried_grade[$plan]['eng_2']){
                    return false;
                }

                if($total_grade >= $this->required_grade[$plan]['total_grade']){
                    return false;
                }

                return true;
            break;
            case '3':
                if(self::averageGrade($tha[1]) >= $this->requried_grade[$plan]['tha_1']){
                    return false;
                }
                if(self::averageGrade($eng[1]) >= $this->requried_grade[$plan]['eng_1']){
                    return false;
                }
                if(self::averageGrade($eng[2]) >= $this->requried_grade[$plan]['eng_2']){
                    return false;
                }
                if(self::averageGrade($soc[1]) >= $this->requried_grade[$plan]['soc_1']){
                    return false;
                }

                if($total_grade >= $this->required_grade[$plan]['total_grade']){
                    return false;
                }

                return true;
            break;
            case '4':
                if(self::averageGrade($tha[1]) >= $this->requried_grade[$plan]['tha_1']){
                    return false;
                }
                if(self::averageGrade($mat[1]) >= $this->requried_grade[$plan]['mat_1']){
                    return false;
                }
                if(self::averageGrade($mat[2]) >= $this->requried_grade[$plan]['mat_2']){
                    return false;
                }
                if(self::averageGrade($eng[1]) >= $this->requried_grade[$plan]['eng_1']){
                    return false;
                }
                if(self::averageGrade($eng[2]) >= $this->requried_grade[$plan]['eng_2']){
                    return false;
                }

                if($total_grade >= $this->required_grade[$plan]['total_grade']){
                    return false;
                }

                return true;
            break;
            case '5':
                if(self::averageGrade($mat[1]) >= $this->requried_grade[$plan]['mat_1']){
                    return false;
                }
                if(self::averageGrade($mat[2]) >= $this->requried_grade[$plan]['mat_2']){
                    return false;
                }
                if(self::averageGrade($sci[1]) >= $this->requried_grade[$plan]['sci_1']){
                    return false;
                }
                if(self::averageGrade($sci[2]) >= $this->requried_grade[$plan]['sci_2']){
                    return false;
                }

                if($total_grade >= $this->required_grade[$plan]['total_grade']){
                    return false;
                }

                return true;
            break;
            default:
                throw new Exception('Unexpected plan');
            break;
        }
    }

    public static function averageGrade(Array $grade){
        return (array_sum($grade)/count($grade));
    }
}
