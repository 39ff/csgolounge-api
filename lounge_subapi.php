<?php
header("Content-Type: application/json; charset=utf-8");
/**
 * Created by PhpStorm.
 * User: kouhei
 * Date: 15/11/19
 * Time: 21:48
 */
$mid = filter_input(INPUT_GET,'mid');
if(ctype_digit($mid) === FALSE){
    exit(':)');
}
$set['code'] = 200;
$set['message'] = "";
try {

    $data = file_get_contents('http://csgolounge.com/match?m='.$mid);
    $preg = preg_match_all("@<b>(.*)</b><br><i>([0-9]++)%</i>@", $data, $m, PREG_SET_ORDER);

    if($preg === 0 || $preg === FALSE){
        throw new Exception();
    }

    foreach ($m as $d) {
        $set['data'][] = array('Name'=>$d[1],'Value'=>$d[2]);
    }



}catch(Exception $e){
    $set['code'] = 500;
    $set['message'] = $e->getMessage();
}
echo json_encode($set);