<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\UIHelper;
use DB;

class ReportController extends Controller
{
    public function generateBCompleteReport(){
        $all = DB::collection('applicants')
                ->where('ui_notified', 0)
                ->orderBy('school_province', 'asc')
                ->orderBy('submitted', 'asc')
                ->get();

        // Create new Spreadsheet object
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('Valkyrie')
                ->setTitle('Valkyrie')
                ->setSubject('Valkyrie')
                ->setDescription('Valkyrie data');

        // Set header
        $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1', 'คำนำหน้าชื่อ')
                ->setCellValue('B1', 'ชื่อ')
                ->setCellValue('C1', 'นามสกุล')
                ->setCellValue('D1', 'คำนำหน้าชื่อภาษาอังกฤษ')
                ->setCellValue('E1', 'ชื่อภาษาอังกฤษ')
                ->setCellValue('F1', 'นามสกุลภาษาอังกฤษ')
                ->setCellValue('G1', 'เพศ')
                ->setCellValue('H1', 'email')
                ->setCellValue('I1', 'เบอร์โทรศัพท์')
                ->setCellValue('J1', 'วันเกิด')
                ->setCellValue('K1', 'อยู่กับผู้ปกครอง')
                ->setCellValue('L1', 'คำนำหน้าชื่อบิดา')
                ->setCellValue('M1', 'ชื่อบิดา')
                ->setCellValue('N1', 'นามสกุลบิดา')
                ->setCellValue('O1', 'เบอร์โทรศัพท์บิดา')
                ->setCellValue('P1', 'อาชีพบิดา')
                ->setCellValue('Q1', 'บิดาเสียชีวิต')
                ->setCellValue('R1', 'คำนำหน้าชื่อมารดา')
                ->setCellValue('S1', 'ชื่อมารดา')
                ->setCellValue('T1', 'นามสกุลมารดา')
                ->setCellValue('U1', 'เบอร์โทรศัพท์มารดา')
                ->setCellValue('V1', 'อาชีพมารดา')
                ->setCellValue('W1', 'มารดาเสียชีวิต')
                ->setCellValue('X1', 'คำนำหน้าชื่อผู้ปกครอง')
                ->setCellValue('Y1', 'ชื่อผู้ปกครอง')
                ->setCellValue('Z1', 'นามสกุลผู้ปกครอง')
                ->setCellValue('AA1', 'เบอร์โทรศัพท์ผู้ปกครอง')
                ->setCellValue('AB1', 'อาชีพผู้ปกครอง')
                ->setCellValue('AC1', 'โรงเรียนชั้น ม.2')
                ->setCellValue('AD1', 'จังหวัดโรงเรียนชั้น ม.2')
                ->setCellValue('AE1', 'โรงเรียนชั้น ม.3')
                ->setCellValue('AF1', 'จังหวัดโรงเรียนชั้น ม.3')
                ->setCellValue('AG1', 'เกรดเฉลี่ยรวม')
                ->setCellValue('AH1', 'ที่อยู่ปัจจุบันเป็นที่อยู่บ้าน')
                ->setCellValue('AI1', 'บ้านเลขที่ตามทะเบียนบ้าน')
                ->setCellValue('AJ1', 'หมู่ตามทะเบียนบ้าน')
                ->setCellValue('AK1', 'ซอยตามทะเบียนบ้าน')
                ->setCellValue('AL1', 'ถนนตามทะเบียนบ้าน')
                ->setCellValue('AM1', 'ตำบลตามทะเบียนบ้าน')
                ->setCellValue('AN1', 'อำเภอตามทะเบียนบ้าน')
                ->setCellValue('AO1', 'จังหวัดตามทะเบียนบ้าน')
                ->setCellValue('AP1', 'รหัสไปรษณีย์ตามทะเบียนบ้าน')
                ->setCellValue('AQ1', 'บ้านเลขที่ปัจจุบัน')
                ->setCellValue('AR1', 'หมู่ปัจจุบัน')
                ->setCellValue('AS1', 'ซอยปัจจุบัน')
                ->setCellValue('AT1', 'ถนนปัจจุบัน')
                ->setCellValue('AU1', 'ตำบลปัจจุบัน')
                ->setCellValue('AV1', 'อำเภอปัจจุบัน')
                ->setCellValue('AW1', 'จังหวัดปัจจุบัน')
                ->setCellValue('AX1', 'รหัสไปรษณีย์ปัจจุบัน')
                ->setCellValue('AY1', 'วันที่ย้ายเข้ามา')
                ->setCellValue('AZ1', 'แผนการเรียน')
                ->setCellValue('BA1', 'ผลการเรียนเฉลี่ยรายวิชาวิทยาศาสตร์พื้นฐาน')
                ->setCellValue('BB1', 'ผลการเรียนเฉลี่ยรายวิชาวิทยาศาสตร์เพิ่มเติม')
                ->setCellValue('BC1', 'ผลการเรียนเฉลี่ยรายวิชาคณิตศาสตร์พื้นฐาน')
                ->setCellValue('BD1', 'ผลการเรียนเฉลี่ยรายวิชาคณิตศาสตร์เพิ่มเติม')
                ->setCellValue('BE1', 'ผลการเรียนเฉลี่ยรายวิชาภาษาอังกฤษพื้นฐาน')
                ->setCellValue('BF1', 'ผลการเรียนเฉลี่ยรายวิชาภาษาอังกฤษเพิ่มเติม')
                ->setCellValue('BG1', 'ผลการเรียนเฉลี่ยรายวิชาภาษาไทยพื้นฐาน')
                ->setCellValue('BH1', 'ผลการเรียนเฉลี่ยรายวิชาสังคมศึกษาพื้นฐาน')
                ->setCellValue('BI1', 'เวลาที่ส่งเข้ามา');

        for($i=2;$i<=count($all); $i++){
            $A = isset($all[$i-2]['title']) ? UIHelper::formatTitle($all[$i-2]['title']) : 'ไม่มีข้อมูล';
            $B = isset($all[$i-2]['fname']) ? $all[$i-2]['fname'] : 'ไม่มีข้อมูล';
            $C = isset($all[$i-2]['lname']) ? $all[$i-2]['lname'] : 'ไม่มีข้อมูล';
            $D = isset($all[$i-2]['title_en']) ? UIHelper::formatTitle($all[$i-2]['title_en'], 'eng') : 'ไม่มีข้อมูล';
            $E = isset($all[$i-2]['fname_en']) ? $all[$i-2]['fname_en'] : 'ไม่มีข้อมูล';
            $F = isset($all[$i-2]['lname_en']) ? $all[$i-2]['lname_en'] : 'ไม่มีข้อมูล';
            $G = isset($all[$i-2]['gender']) ? $all[$i-2]['gender'] : 'ไม่มีข้อมูล';
            $H = isset($all[$i-2]['email']) ? $all[$i-2]['email'] : 'ไม่มีข้อมูล';
            $I = isset($all[$i-2]['phone']) ? $all[$i-2]['phone'] : 'ไม่มีข้อมูล';
            $J = isset($all[$i-2]['birthdate']['day']) && isset($all[$i-2]['birthdate']['month']) && isset($all[$i-2]['birthdate']['year']) ? $all[$i-2]['birthdate']['day'] .'/'. $all[$i-2]['birthdate']['month'] .'/'. $all[$i-2]['birthdate']['year'] : 'ไม่มีข้อมูล';
            $K = isset($all[$i-2]['staying_with_parent']) ? $all[$i-2]['staying_with_parent'] : 'ไม่มีข้อมูล';
            $L = isset($all[$i-2]['father']['title']) ? $all[$i-2]['father']['title'] : 'ไม่มีข้อมูล';
            $M = isset($all[$i-2]['father']['fname']) ? $all[$i-2]['father']['fname'] : 'ไม่มีข้อมูล';
            $N = isset($all[$i-2]['father']['lname']) ? $all[$i-2]['father']['lname'] : 'ไม่มีข้อมูล';
            $O = isset($all[$i-2]['father']['phone']) ? $all[$i-2]['father']['phone'] : 'ไม่มีข้อมูล';
            $P = isset($all[$i-2]['father']['occupation']) ? $all[$i-2]['father']['occupation'] : 'ไม่มีข้อมูล';
            $Q = isset($all[$i-2]['father']['dead']) ? $all[$i-2]['father']['dead'] : 'ไม่มีข้อมูล';
            $R = isset($all[$i-2]['mother']['title']) ? $all[$i-2]['mother']['title'] : 'ไม่มีข้อมูล';
            $S = isset($all[$i-2]['mother']['fname']) ? $all[$i-2]['mother']['fname'] : 'ไม่มีข้อมูล';
            $T = isset($all[$i-2]['mother']['lname']) ? $all[$i-2]['mother']['lname'] : 'ไม่มีข้อมูล';
            $U = isset($all[$i-2]['mother']['phone']) ? $all[$i-2]['mother']['phone'] : 'ไม่มีข้อมูล';
            $V = isset($all[$i-2]['mother']['occupation']) ? $all[$i-2]['mother']['occupation'] : 'ไม่มีข้อมูล';
            $W = isset($all[$i-2]['mother']['dead']) ? $all[$i-2]['mother']['dead'] : 'ไม่มีข้อมูล';
            $X = isset($all[$i-2]['guardian']['title']) ? $all[$i-2]['guardian']['title'] : 'ไม่มีข้อมูล';
            $Y = isset($all[$i-2]['guardian']['fname']) ? $all[$i-2]['guardian']['fname'] : 'ไม่มีข้อมูล';
            $Z = isset($all[$i-2]['guardian']['lname']) ? $all[$i-2]['guardian']['lname'] : 'ไม่มีข้อมูล';
            $AA = isset($all[$i-2]['guardian']['phone']) ? $all[$i-2]['guardian']['phone'] : 'ไม่มีข้อมูล';
            $AB = isset($all[$i-2]['guardian']['occupation']) ? $all[$i-2]['guardian']['occupation'] : 'ไม่มีข้อมูล';
            $AC = isset($all[$i-2]['school2']) ? $all[$i-2]['school2'] : 'ไม่มีข้อมูล';
            $AD = isset($all[$i-2]['school2_province']) ? $all[$i-2]['school2_province'] : 'ไม่มีข้อมูล';
            $AE = isset($all[$i-2]['school']) ? $all[$i-2]['school'] : 'ไม่มีข้อมูล';
            $AF = isset($all[$i-2]['school_province']) ? $all[$i-2]['school_province'] : 'ไม่มีข้อมูล';
            $AG = isset($all[$i-2]['gpa']) ? $all[$i-2]['gpa'] : 'ไม่มีข้อมูล';
            $AH = isset($all[$i-2]['address']['current_address_same_as_home']) ? $all[$i-2]['address']['current_address_same_as_home'] : 'ไม่มีข้อมูล';
            $AI = isset($all[$i-2]['address']['home']['home_address']) ? $all[$i-2]['address']['home']['home_address'] : 'ไม่มีข้อมูล';
            $AJ = isset($all[$i-2]['address']['home']['home_moo']) ? $all[$i-2]['address']['home']['home_moo'] : 'ไม่มีข้อมูล';
            $AK = isset($all[$i-2]['address']['home']['home_soi']) ? $all[$i-2]['address']['home']['home_soi'] : 'ไม่มีข้อมูล';
            $AL = isset($all[$i-2]['address']['home']['home_road']) ? $all[$i-2]['address']['home']['home_road'] : 'ไม่มีข้อมูล';
            $AM = isset($all[$i-2]['address']['home']['home_subdistrict']) ? $all[$i-2]['address']['home']['home_subdistrict'] : 'ไม่มีข้อมูล';
            $AN = isset($all[$i-2]['address']['home']['home_district']) ? $all[$i-2]['address']['home']['home_district'] : 'ไม่มีข้อมูล';
            $AO = isset($all[$i-2]['address']['home']['home_province']) ? $all[$i-2]['address']['home']['home_province'] : 'ไม่มีข้อมูล';
            $AP = isset($all[$i-2]['address']['home']['home_postcode']) ? $all[$i-2]['address']['home']['home_postcode'] : 'ไม่มีข้อมูล';
            $AQ = isset($all[$i-2]['address']['current']['current_address']) ? $all[$i-2]['address']['current']['current_address'] : 'ไม่มีข้อมูล';
            $AR = isset($all[$i-2]['address']['current']['current_moo']) ? $all[$i-2]['address']['current']['current_moo'] : 'ไม่มีข้อมูล';
            $AS = isset($all[$i-2]['address']['current']['current_soi']) ? $all[$i-2]['address']['current']['current_soi'] : 'ไม่มีข้อมูล';
            $AT = isset($all[$i-2]['address']['current']['current_road']) ? $all[$i-2]['address']['current']['current_road'] : 'ไม่มีข้อมูล';
            $AU = isset($all[$i-2]['address']['current']['current_subdistrict']) ? $all[$i-2]['address']['current']['current_subdistrict'] : 'ไม่มีข้อมูล';
            $AV = isset($all[$i-2]['address']['current']['current_district']) ? $all[$i-2]['address']['current']['current_district'] : 'ไม่มีข้อมูล';
            $AW = isset($all[$i-2]['address']['current']['current_province']) ? $all[$i-2]['address']['current']['current_province'] : 'ไม่มีข้อมูล';
            $AX = isset($all[$i-2]['address']['current']['current_postcode']) ? $all[$i-2]['address']['current']['current_postcode'] : 'ไม่มีข้อมูล';
            $AY = isset($all[$i-2]['address']['home_move_in_day']) && isset($all[$i-2]['address']['home_move_in_month']) && isset($all[$i-2]['address']['home_move_in_year']) ? $all[$i-2]['address']['home_move_in_day'] .'/'. $all[$i-2]['address']['home_move_in_month'] .'/'. $all[$i-2]['address']['home_move_in_year'] : 'ไม่มีข้อมูล';
            $AZ = isset($all[$i-2]['plan']) ? UIHelper::formatPlan($all[$i-2]['plan']) : 'ไม่มีข้อมูล';
            $BA = isset($all[$i-2]['quota_grade']['science_basic']) ? $all[$i-2]['quota_grade']['science_basic'] : 'ไม่มีข้อมูล';
            $BB = isset($all[$i-2]['quota_grade']['science_advanced']) ? $all[$i-2]['quota_grade']['science_advanced'] : 'ไม่มีข้อมูล';
            $BC = isset($all[$i-2]['quota_grade']['math_basic']) ? $all[$i-2]['quota_grade']['math_basic'] : 'ไม่มีข้อมูล';
            $BD = isset($all[$i-2]['quota_grade']['math_advanced']) ? $all[$i-2]['quota_grade']['math_advanced'] : 'ไม่มีข้อมูล';
            $BE = isset($all[$i-2]['quota_grade']['english_basic']) ? $all[$i-2]['quota_grade']['english_basic'] : 'ไม่มีข้อมูล';
            $BF = isset($all[$i-2]['quota_grade']['english_advanced']) ? $all[$i-2]['quota_grade']['english_advanced'] : 'ไม่มีข้อมูล';
            $BG = isset($all[$i-2]['quota_grade']['thai_basic']) ? $all[$i-2]['quota_grade']['thai_basic'] : 'ไม่มีข้อมูล';
            $BH = isset($all[$i-2]['quota_grade']['social_basic']) ? $all[$i-2]['quota_grade']['social_basic'] : 'ไม่มีข้อมูล';
            $BI = isset($all[$i-2]['submitted']) ? $all[$i-2]['submitted'] : 'ไม่มีข้อมูล';

            // Set data
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValueExplicit('A'.$i, $A, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('B'.$i, $B, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('C'.$i, $C, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('D'.$i, $D, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('E'.$i, $E, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('F'.$i, $F, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('G'.$i, $G, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('H'.$i, $H, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('I'.$i, $I, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('J'.$i, $J, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('K'.$i, $K, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('L'.$i, $L, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('M'.$i, $M, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('N'.$i, $N, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('O'.$i, $O, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('P'.$i, $P, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('Q'.$i, $Q, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('R'.$i, $R, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('S'.$i, $S, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('T'.$i, $T, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('U'.$i, $U, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('V'.$i, $V, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('W'.$i, $W, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('X'.$i, $X, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('Y'.$i, $Y, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('Z'.$i, $Z, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AA'.$i, $AA, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AB'.$i, $AB, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AC'.$i, $AC, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AD'.$i, $AD, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AE'.$i, $AE, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AF'.$i, $AF, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AG'.$i, $AG, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AH'.$i, $AH, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AI'.$i, $AI, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AJ'.$i, $AJ, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AK'.$i, $AK, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AL'.$i, $AL, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AM'.$i, $AM, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AN'.$i, $AN, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AO'.$i, $AO, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AP'.$i, $AP, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AQ'.$i, $AQ, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AR'.$i, $AR, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AS'.$i, $AS, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AT'.$i, $AT, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AU'.$i, $AU, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AV'.$i, $AV, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AW'.$i, $AW, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AX'.$i, $AX, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AY'.$i, $AY, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AZ'.$i, $AZ, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('BA'.$i, $BA, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('BB'.$i, $BB, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('BC'.$i, $BC, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('BD'.$i, $BD, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('BE'.$i, $BE, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('BF'.$i, $BF, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('BG'.$i, $BG, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('BH'.$i, $BH, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('BI'.$i, $BI, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        }

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('ฐานข้อมูล B ฉบับสมบูรณ์');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Set filename and path

        $path = storage_path('ฐานข้อมูล B ฉบับสมบูรณ์.xlsx');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Excel2007');
        $writer->save($path);

        $spreadsheet->disconnectWorksheets();

        return $path;
    }

    public function generateBCompactReport(){
        $all = DB::collection('applicants')
                ->where('ui_notified', 0)
                ->orderBy('school_province', 'asc')
                ->orderBy('submitted', 'asc')
                ->get();

        // Create new Spreadsheet object
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('Valkyrie')
                ->setTitle('Valkyrie')
                ->setSubject('Valkyrie')
                ->setDescription('Valkyrie data');

        // Set header
        $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1', 'คำนำหน้าชื่อ')
                ->setCellValue('B1', 'ชื่อ')
                ->setCellValue('C1', 'นามสกุล')
                ->setCellValue('D1', 'เลขประจำตัวประชาชน')
                ->setCellValue('E1', 'โรงเรียนชั้นม.3')
                ->setCellValue('F1', 'จังหวัดโรงเรียนชั้นม.3');

        for($i=2;$i<=count($all); $i++){
            // Set data
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, isset($all[$i-2]['title']) ? UIHelper::formatTitle($all[$i-2]['title']) : 'ไม่มีข้อมูล')
                ->setCellValue('B'.$i, isset($all[$i-2]['fname']) ? $all[$i-2]['fname'] : 'ไม่มีข้อมูล')
                ->setCellValue('C'.$i, isset($all[$i-2]['lname']) ? $all[$i-2]['lname'] : 'ไม่มีข้อมูล')
                ->setCellValueExplicit('D'.$i, isset($all[$i-2]['citizen_id']) ? $all[$i-2]['citizen_id'] : 'ไม่มีข้อมูล', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValue('E'.$i, isset($all[$i-2]['school']) ? $all[$i-2]['school'] : 'ไม่มีข้อมูล')
                ->setCellValue('F'.$i, isset($all[$i-2]['school_province']) ? $all[$i-2]['school_province'] : 'ไม่มีข้อมูล');
        }

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('ฐานข้อมูล B (สำหรับตรวจเอกสาร)');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Set filename and path

        $path = storage_path('ฐานข้อมูล B สำหรับตรวจเอกสาร.xlsx');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Excel2007');
        $writer->save($path);

        $spreadsheet->disconnectWorksheets();

        return $path;
    }

    public function generateCCompleteReport(){
        $all = DB::collection('passed_applicants')
                ->orderBy('school_province', 'asc')
                ->orderBy('submitted', 'asc')
                ->get();

        // Create new Spreadsheet object
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('Valkyrie')
                ->setTitle('Valkyrie')
                ->setSubject('Valkyrie')
                ->setDescription('Valkyrie data');

        // Set header
        $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1', 'คำนำหน้าชื่อ')
                ->setCellValue('B1', 'ชื่อ')
                ->setCellValue('C1', 'นามสกุล')
                ->setCellValue('D1', 'คำนำหน้าชื่อภาษาอังกฤษ')
                ->setCellValue('E1', 'ชื่อภาษาอังกฤษ')
                ->setCellValue('F1', 'นามสกุลภาษาอังกฤษ')
                ->setCellValue('G1', 'เพศ')
                ->setCellValue('H1', 'email')
                ->setCellValue('I1', 'เบอร์โทรศัพท์')
                ->setCellValue('J1', 'วันเกิด')
                ->setCellValue('K1', 'อยู่กับผู้ปกครอง')
                ->setCellValue('L1', 'คำนำหน้าชื่อบิดา')
                ->setCellValue('M1', 'ชื่อบิดา')
                ->setCellValue('N1', 'นามสกุลบิดา')
                ->setCellValue('O1', 'เบอร์โทรศัพท์บิดา')
                ->setCellValue('P1', 'อาชีพบิดา')
                ->setCellValue('Q1', 'บิดาเสียชีวิต')
                ->setCellValue('R1', 'คำนำหน้าชื่อมารดา')
                ->setCellValue('S1', 'ชื่อมารดา')
                ->setCellValue('T1', 'นามสกุลมารดา')
                ->setCellValue('U1', 'เบอร์โทรศัพท์มารดา')
                ->setCellValue('V1', 'อาชีพมารดา')
                ->setCellValue('W1', 'มารดาเสียชีวิต')
                ->setCellValue('X1', 'คำนำหน้าชื่อผู้ปกครอง')
                ->setCellValue('Y1', 'ชื่อผู้ปกครอง')
                ->setCellValue('Z1', 'นามสกุลผู้ปกครอง')
                ->setCellValue('AA1', 'เบอร์โทรศัพท์ผู้ปกครอง')
                ->setCellValue('AB1', 'อาชีพผู้ปกครอง')
                ->setCellValue('AC1', 'โรงเรียนชั้น ม.2')
                ->setCellValue('AD1', 'จังหวัดโรงเรียนชั้น ม.2')
                ->setCellValue('AE1', 'โรงเรียนชั้น ม.3')
                ->setCellValue('AF1', 'จังหวัดโรงเรียนชั้น ม.3')
                ->setCellValue('AG1', 'เกรดเฉลี่ยรวม')
                ->setCellValue('AH1', 'ที่อยู่ปัจจุบันเป็นที่อยู่บ้าน')
                ->setCellValue('AI1', 'บ้านเลขที่ตามทะเบียนบ้าน')
                ->setCellValue('AJ1', 'หมู่ตามทะเบียนบ้าน')
                ->setCellValue('AK1', 'ซอยตามทะเบียนบ้าน')
                ->setCellValue('AL1', 'ถนนตามทะเบียนบ้าน')
                ->setCellValue('AM1', 'ตำบลตามทะเบียนบ้าน')
                ->setCellValue('AN1', 'อำเภอตามทะเบียนบ้าน')
                ->setCellValue('AO1', 'จังหวัดตามทะเบียนบ้าน')
                ->setCellValue('AP1', 'รหัสไปรษณีย์ตามทะเบียนบ้าน')
                ->setCellValue('AQ1', 'บ้านเลขที่ปัจจุบัน')
                ->setCellValue('AR1', 'หมู่ปัจจุบัน')
                ->setCellValue('AS1', 'ซอยปัจจุบัน')
                ->setCellValue('AT1', 'ถนนปัจจุบัน')
                ->setCellValue('AU1', 'ตำบลปัจจุบัน')
                ->setCellValue('AV1', 'อำเภอปัจจุบัน')
                ->setCellValue('AW1', 'จังหวัดปัจจุบัน')
                ->setCellValue('AX1', 'รหัสไปรษณีย์ปัจจุบัน')
                ->setCellValue('AY1', 'วันที่ย้ายเข้ามา')
                ->setCellValue('AZ1', 'แผนการเรียน')
                ->setCellValue('BA1', 'ผลการเรียนเฉลี่ยรายวิชาวิทยาศาสตร์พื้นฐาน')
                ->setCellValue('BB1', 'ผลการเรียนเฉลี่ยรายวิชาวิทยาศาสตร์เพิ่มเติม')
                ->setCellValue('BC1', 'ผลการเรียนเฉลี่ยรายวิชาคณิตศาสตร์พื้นฐาน')
                ->setCellValue('BD1', 'ผลการเรียนเฉลี่ยรายวิชาคณิตศาสตร์เพิ่มเติม')
                ->setCellValue('BE1', 'ผลการเรียนเฉลี่ยรายวิชาภาษาอังกฤษพื้นฐาน')
                ->setCellValue('BF1', 'ผลการเรียนเฉลี่ยรายวิชาภาษาอังกฤษเพิ่มเติม')
                ->setCellValue('BG1', 'ผลการเรียนเฉลี่ยรายวิชาภาษาไทยพื้นฐาน')
                ->setCellValue('BH1', 'ผลการเรียนเฉลี่ยรายวิชาสังคมศึกษาพื้นฐาน')
                ->setCellValue('BI1', 'เวลาที่ส่งเข้ามา');

        for($i=2;$i<=count($all); $i++){
            $A = isset($all[$i-2]['title']) ? UIHelper::formatTitle($all[$i-2]['title']) : 'ไม่มีข้อมูล';
            $B = isset($all[$i-2]['fname']) ? $all[$i-2]['fname'] : 'ไม่มีข้อมูล';
            $C = isset($all[$i-2]['lname']) ? $all[$i-2]['lname'] : 'ไม่มีข้อมูล';
            $D = isset($all[$i-2]['title_en']) ? UIHelper::formatTitle($all[$i-2]['title_en'], 'eng') : 'ไม่มีข้อมูล';
            $E = isset($all[$i-2]['fname_en']) ? $all[$i-2]['fname_en'] : 'ไม่มีข้อมูล';
            $F = isset($all[$i-2]['lname_en']) ? $all[$i-2]['lname_en'] : 'ไม่มีข้อมูล';
            $G = isset($all[$i-2]['gender']) ? $all[$i-2]['gender'] : 'ไม่มีข้อมูล';
            $H = isset($all[$i-2]['email']) ? $all[$i-2]['email'] : 'ไม่มีข้อมูล';
            $I = isset($all[$i-2]['phone']) ? $all[$i-2]['phone'] : 'ไม่มีข้อมูล';
            $J = isset($all[$i-2]['birthdate']['day']) && isset($all[$i-2]['birthdate']['month']) && isset($all[$i-2]['birthdate']['year']) ? $all[$i-2]['birthdate']['day'] .'/'. $all[$i-2]['birthdate']['month'] .'/'. $all[$i-2]['birthdate']['year'] : 'ไม่มีข้อมูล';
            $K = isset($all[$i-2]['staying_with_parent']) ? $all[$i-2]['staying_with_parent'] : 'ไม่มีข้อมูล';
            $L = isset($all[$i-2]['father']['title']) ? $all[$i-2]['father']['title'] : 'ไม่มีข้อมูล';
            $M = isset($all[$i-2]['father']['fname']) ? $all[$i-2]['father']['fname'] : 'ไม่มีข้อมูล';
            $N = isset($all[$i-2]['father']['lname']) ? $all[$i-2]['father']['lname'] : 'ไม่มีข้อมูล';
            $O = isset($all[$i-2]['father']['phone']) ? $all[$i-2]['father']['phone'] : 'ไม่มีข้อมูล';
            $P = isset($all[$i-2]['father']['occupation']) ? $all[$i-2]['father']['occupation'] : 'ไม่มีข้อมูล';
            $Q = isset($all[$i-2]['father']['dead']) ? $all[$i-2]['father']['dead'] : 'ไม่มีข้อมูล';
            $R = isset($all[$i-2]['mother']['title']) ? $all[$i-2]['mother']['title'] : 'ไม่มีข้อมูล';
            $S = isset($all[$i-2]['mother']['fname']) ? $all[$i-2]['mother']['fname'] : 'ไม่มีข้อมูล';
            $T = isset($all[$i-2]['mother']['lname']) ? $all[$i-2]['mother']['lname'] : 'ไม่มีข้อมูล';
            $U = isset($all[$i-2]['mother']['phone']) ? $all[$i-2]['mother']['phone'] : 'ไม่มีข้อมูล';
            $V = isset($all[$i-2]['mother']['occupation']) ? $all[$i-2]['mother']['occupation'] : 'ไม่มีข้อมูล';
            $W = isset($all[$i-2]['mother']['dead']) ? $all[$i-2]['mother']['dead'] : 'ไม่มีข้อมูล';
            $X = isset($all[$i-2]['guardian']['title']) ? $all[$i-2]['guardian']['title'] : 'ไม่มีข้อมูล';
            $Y = isset($all[$i-2]['guardian']['fname']) ? $all[$i-2]['guardian']['fname'] : 'ไม่มีข้อมูล';
            $Z = isset($all[$i-2]['guardian']['lname']) ? $all[$i-2]['guardian']['lname'] : 'ไม่มีข้อมูล';
            $AA = isset($all[$i-2]['guardian']['phone']) ? $all[$i-2]['guardian']['phone'] : 'ไม่มีข้อมูล';
            $AB = isset($all[$i-2]['guardian']['occupation']) ? $all[$i-2]['guardian']['occupation'] : 'ไม่มีข้อมูล';
            $AC = isset($all[$i-2]['school2']) ? $all[$i-2]['school2'] : 'ไม่มีข้อมูล';
            $AD = isset($all[$i-2]['school2_province']) ? $all[$i-2]['school2_province'] : 'ไม่มีข้อมูล';
            $AE = isset($all[$i-2]['school']) ? $all[$i-2]['school'] : 'ไม่มีข้อมูล';
            $AF = isset($all[$i-2]['school_province']) ? $all[$i-2]['school_province'] : 'ไม่มีข้อมูล';
            $AG = isset($all[$i-2]['gpa']) ? $all[$i-2]['gpa'] : 'ไม่มีข้อมูล';
            $AH = isset($all[$i-2]['address']['current_address_same_as_home']) ? $all[$i-2]['address']['current_address_same_as_home'] : 'ไม่มีข้อมูล';
            $AI = isset($all[$i-2]['address']['home']['home_address']) ? $all[$i-2]['address']['home']['home_address'] : 'ไม่มีข้อมูล';
            $AJ = isset($all[$i-2]['address']['home']['home_moo']) ? $all[$i-2]['address']['home']['home_moo'] : 'ไม่มีข้อมูล';
            $AK = isset($all[$i-2]['address']['home']['home_soi']) ? $all[$i-2]['address']['home']['home_soi'] : 'ไม่มีข้อมูล';
            $AL = isset($all[$i-2]['address']['home']['home_road']) ? $all[$i-2]['address']['home']['home_road'] : 'ไม่มีข้อมูล';
            $AM = isset($all[$i-2]['address']['home']['home_subdistrict']) ? $all[$i-2]['address']['home']['home_subdistrict'] : 'ไม่มีข้อมูล';
            $AN = isset($all[$i-2]['address']['home']['home_district']) ? $all[$i-2]['address']['home']['home_district'] : 'ไม่มีข้อมูล';
            $AO = isset($all[$i-2]['address']['home']['home_province']) ? $all[$i-2]['address']['home']['home_province'] : 'ไม่มีข้อมูล';
            $AP = isset($all[$i-2]['address']['home']['home_postcode']) ? $all[$i-2]['address']['home']['home_postcode'] : 'ไม่มีข้อมูล';
            $AQ = isset($all[$i-2]['address']['current']['current_address']) ? $all[$i-2]['address']['current']['current_address'] : 'ไม่มีข้อมูล';
            $AR = isset($all[$i-2]['address']['current']['current_moo']) ? $all[$i-2]['address']['current']['current_moo'] : 'ไม่มีข้อมูล';
            $AS = isset($all[$i-2]['address']['current']['current_soi']) ? $all[$i-2]['address']['current']['current_soi'] : 'ไม่มีข้อมูล';
            $AT = isset($all[$i-2]['address']['current']['current_road']) ? $all[$i-2]['address']['current']['current_road'] : 'ไม่มีข้อมูล';
            $AU = isset($all[$i-2]['address']['current']['current_subdistrict']) ? $all[$i-2]['address']['current']['current_subdistrict'] : 'ไม่มีข้อมูล';
            $AV = isset($all[$i-2]['address']['current']['current_district']) ? $all[$i-2]['address']['current']['current_district'] : 'ไม่มีข้อมูล';
            $AW = isset($all[$i-2]['address']['current']['current_province']) ? $all[$i-2]['address']['current']['current_province'] : 'ไม่มีข้อมูล';
            $AX = isset($all[$i-2]['address']['current']['current_postcode']) ? $all[$i-2]['address']['current']['current_postcode'] : 'ไม่มีข้อมูล';
            $AY = isset($all[$i-2]['address']['home_move_in_day']) && isset($all[$i-2]['address']['home_move_in_month']) && isset($all[$i-2]['address']['home_move_in_year']) ? $all[$i-2]['address']['home_move_in_day'] .'/'. $all[$i-2]['address']['home_move_in_month'] .'/'. $all[$i-2]['address']['home_move_in_year'] : 'ไม่มีข้อมูล';
            $AZ = isset($all[$i-2]['plan']) ? UIHelper::formatPlan($all[$i-2]['plan']) : 'ไม่มีข้อมูล';
            $BA = isset($all[$i-2]['quota_grade']['science_basic']) ? $all[$i-2]['quota_grade']['science_basic'] : 'ไม่มีข้อมูล';
            $BB = isset($all[$i-2]['quota_grade']['science_advanced']) ? $all[$i-2]['quota_grade']['science_advanced'] : 'ไม่มีข้อมูล';
            $BC = isset($all[$i-2]['quota_grade']['math_basic']) ? $all[$i-2]['quota_grade']['math_basic'] : 'ไม่มีข้อมูล';
            $BD = isset($all[$i-2]['quota_grade']['math_advanced']) ? $all[$i-2]['quota_grade']['math_advanced'] : 'ไม่มีข้อมูล';
            $BE = isset($all[$i-2]['quota_grade']['english_basic']) ? $all[$i-2]['quota_grade']['english_basic'] : 'ไม่มีข้อมูล';
            $BF = isset($all[$i-2]['quota_grade']['english_advanced']) ? $all[$i-2]['quota_grade']['english_advanced'] : 'ไม่มีข้อมูล';
            $BG = isset($all[$i-2]['quota_grade']['thai_basic']) ? $all[$i-2]['quota_grade']['thai_basic'] : 'ไม่มีข้อมูล';
            $BH = isset($all[$i-2]['quota_grade']['social_basic']) ? $all[$i-2]['quota_grade']['social_basic'] : 'ไม่มีข้อมูล';
            $BI = isset($all[$i-2]['submitted']) ? $all[$i-2]['submitted'] : 'ไม่มีข้อมูล';

            // Set data
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValueExplicit('A'.$i, $A, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('B'.$i, $B, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('C'.$i, $C, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('D'.$i, $D, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('E'.$i, $E, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('F'.$i, $F, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('G'.$i, $G, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('H'.$i, $H, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('I'.$i, $I, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('J'.$i, $J, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('K'.$i, $K, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('L'.$i, $L, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('M'.$i, $M, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('N'.$i, $N, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('O'.$i, $O, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('P'.$i, $P, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('Q'.$i, $Q, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('R'.$i, $R, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('S'.$i, $S, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('T'.$i, $T, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('U'.$i, $U, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('V'.$i, $V, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('W'.$i, $W, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('X'.$i, $X, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('Y'.$i, $Y, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('Z'.$i, $Z, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AA'.$i, $AA, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AB'.$i, $AB, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AC'.$i, $AC, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AD'.$i, $AD, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AE'.$i, $AE, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AF'.$i, $AF, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AG'.$i, $AG, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AH'.$i, $AH, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AI'.$i, $AI, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AJ'.$i, $AJ, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AK'.$i, $AK, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AL'.$i, $AL, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AM'.$i, $AM, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AN'.$i, $AN, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AO'.$i, $AO, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AP'.$i, $AP, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AQ'.$i, $AQ, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AR'.$i, $AR, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AS'.$i, $AS, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AT'.$i, $AT, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AU'.$i, $AU, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AV'.$i, $AV, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AW'.$i, $AW, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AX'.$i, $AX, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AY'.$i, $AY, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('AZ'.$i, $AZ, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('BA'.$i, $BA, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('BB'.$i, $BB, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('BC'.$i, $BC, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('BD'.$i, $BD, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('BE'.$i, $BE, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('BF'.$i, $BF, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('BG'.$i, $BG, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('BH'.$i, $BH, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValueExplicit('BI'.$i, $BI, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        }

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('ฐานข้อมูล C ฉบับสมบูรณ์');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Set filename and path

        $path = storage_path('ฐานข้อมูล C ฉบับสมบูรณ์.xlsx');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Excel2007');
        $writer->save($path);

        $spreadsheet->disconnectWorksheets();

        return $path;
    }
}
