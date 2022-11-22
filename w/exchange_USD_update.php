<?
include("../config.php3");
$D_charset="EUC-KR";

//이스케이프
function esc($str,$reg="/[^0-9]/i"){
return preg_replace($reg,"",$str);
}

//파일불러오기

function getFilePs($url) {

$info = parse_url($url);
$host = $info["host"];
$port = $info["port"];
$path = $info["path"];
$body = false;

        if (!$port) $port = 80;
        if ($info["query"]) $path .= "?" . $info["query"];

        if ($fp = fsockopen($host, $port, $errno, $errstr, 3)) {
                fputs($fp, "GET $path HTTP/1.0\r\nHost: $host\r\n\r\n");

                while (!feof($fp)) {
                        $packet = fgets($fp, 256);

                        if ($packet == "\r\n") {
                                $body = true;
                        } else {
                                if ($body) $data .= $packet;
                        }
                }

                fclose($fp);
        }

        return $data;
}

header("Content-Type:text/html;charset=".$D_charset);//인코딩

$url="http://info.finance.naver.com/marketindex/exchangeList.nhn";
$url="http://card.weneedweb.com/w/exchange.php" ;

$rs1=getFilePs($url);

$rs1 = explode("<tbody>",$rs1);
$rs1 = explode("<tr>",$rs1[1]);
$size = sizeof($rs1);

for ( $i = 1 ; $i < $size ; $i ++ ) {

$arr1 = $rs1[$i] ;
$arr2 = explode("</td>",$arr1);

$arr3_1 = trim(strip_tags($arr2[0]));
$arr3_1 = explode(" ",$arr3_1);

$ex_name = $arr3_1[1] ; // ex : USD
$nations[$ex_name] = $arr3_1[0] ;       // ex : 미국

$arr3_2 = trim(strip_tags($arr2[1]));   // 매매기준율
$arr3_3 = trim(strip_tags($arr2[2]));   // 현찰 사실때
$arr3_4 = trim(strip_tags($arr2[31));  // 현찰 파실때
$arr3_5 = trim(strip_tags($arr2[4]));   // 송금 보내실때
$arr3_6 = trim(strip_tags($arr2[5]));   // 송금 받으실때

$ex1[$ex_name] = $arr3_2 ;
$ex2[$ex_name] = $arr3_3 ;
$ex3[$ex_name] = $arr3_4 ;
$ex4[$ex_name] = $arr3_5 ;
$ex5[$ex_name] = $arr3_6 ;
/*
echo(strip_tags($arr2[0]));
echo(strip_tags($arr2[1]));     //매매기준율
echo(strip_tags($arr2[2])); // 현찰 사실때
echo(strip_tags($arr2[3])); // 현찰 파실때
echo(strip_tags($arr2[4]));     // 송금 보내실때
echo(strip_tags($arr2[5])); // 송금 받으실때
echo("<br>");
*/

}






$exchange_USD = str_replace(",","",$ex2[USD]) ;
$qstringJ = " update JUNGBO set " ;
$qstringJ.= " exchange_USD='$exchange_USD' " ;
$qstringJ.= " where number='1' " ;
if($WNW[exchange_USD_type]=="1") mysqli_query($mysql_con,$qstringJ);
?>
