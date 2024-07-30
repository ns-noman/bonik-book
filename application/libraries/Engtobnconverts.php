<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class Engtobnconverts {

function getBdCurrency($number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    //$paise = ($decimal > 0) ? "and " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    $paise = ($decimal > 0) ? "and " . ($words[(int)($decimal/10)*10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Taka ' : '') . $paise;
}

function getBdDate($date)
{
    //$currentDate = date("l, F j, Y");
    $engDATE = array('1','2','3','4','5','6','7','8','9','0','January','February','March','April',
    'May','June','July','August','September','October','November','December','Saturday','Sunday',
    'Monday','Tuesday','Wednesday','Thursday','Friday');
    $bangDATE = array('১','২','৩','৪','৫','৬','৭','৮','৯','০','জানুয়ারী','ফেব্রুয়ারী','মার্চ','এপ্রিল','মে',
    'জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর','শনিবার','রবিবার','সোমবার','মঙ্গলবার','
    বুধবার','বৃহস্পতিবার','শুক্রবার' 
    );
    $convertedDATE = str_replace($engDATE, $bangDATE, $date);
    return $convertedDATE;
    //echo "$convertedDATE";
}

function en2bnNumber ($number)
{
    $bn_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
    $en_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    $bn_number = str_replace($en_array, $bn_array, $number);

    return $bn_number;
}

function taka_format($amount)
{
$amount_val =  number_format((float)$amount, 2, '.', '');
$tmp = explode(".",$amount_val);  // for float or double values
$strMoney = "";
$amount_val = $tmp[0];
$strMoney .= substr($amount_val, -3,3 ) ;
$amount_val = substr($amount_val, 0,-3 ) ;
while(strlen($amount_val)>0)
{
$strMoney = substr($amount_val, -2,2 ).",".$strMoney;
$amount_val = substr($amount_val, 0,-2 );
}

if(isset($tmp[1]))         // if float and double add the decimal digits here.
{
return $strMoney.".".$tmp[1];
}
return $strMoney;
}

}
?>