<?
## 이 페이지에서는 절대 php 만 존재하여야 합니다.

$WeeK = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat") ;

$path_image	= $incpath."/images/" ;
$path_file	= $incpath."/images/files/" ;

//-------------------- 기본정보 세팅 START --------------------//
$qstring = " select * from CATED where D_code='$D_code' " ;
$result = mysqli_query($mysql_con,$qstring);
$WNW = mysqli_fetch_array($result);

$metatext1 = $WNW[metatext1] ;				// 메타 태그
$metatext2 = $WNW[metatext2] ;				// 메타 태그

$main_title = $WNW[main_title] ;			// 제목 표시줄
//-------------------- 기본정보 세팅 END --------------------//



//-------------------- 경로를 추적합니다. START --------------------//
if ( $SP_ok != "Y" ) {

	if ( $SPATH == "" ) $SPATH = getenv("HTTP_REFERER") ; // 1차 체크
	if ( $SPATH != "" ) $SPATH = str_replace("http://","",$SPATH);

	SetCookie("SPATH",$SPATH,0,"/");
	SetCookie("SP_ok","Y",0,"/");

}
//-------------------- 경로를 추적합니다. END --------------------//




//---------------------- 암호화 s -----------------------//
function make_passwords($n){
	global $mysql_con ;
	$query = "select password('$n') " ;
	$result = mysqli_query($mysql_con,$query);
	$temp = mysqli_fetch_array($result);
	return $temp[0];
}
//---------------------- 암호화 e -----------------------//





//---------------------- 환율 적용 s -----------------------//
function cal_KRW($cost,$ex,$ex_cost) {
	global $WNW ;

	if ( $ex_cost ) {
		if ( $ex == "USD" ) $cost = $cost * str_replace(",","",$ex_cost) ;
		if ( $ex == "THB" ) $cost = $cost * str_replace(",","",$ex_cost) ;
		if ( $ex == "VND" ) $cost = $cost * str_replace(",","",$ex_cost) / 100 ;	// 동은 100으로 나누어줘야 한다.
	} else { // 들고 들어온 환율이 없으면 기본값으로...
		if ( $ex == "USD" ) $cost = $cost * str_replace(",","",$WNW[exchange_USD]) ;
		if ( $ex == "THB" ) $cost = $cost * str_replace(",","",$WNW[exchange_THB]) ;
		if ( $ex == "VND" ) $cost = $cost * str_replace(",","",$WNW[exchange_VND]) / 100 ;	// 동은 100으로 나누어줘야 한다.
	}

	return $cost ;
}
//---------------------- 환율 적용 e -----------------------//





//------------------------------ cal s ------------------------------//
function cal_date($ymd,$add) {

	 $timestamp = strtotime("$ymd + $add days");
	 $v = date("Y-m-d",$timestamp);

	return $v ;
}
//------------------------------ cal e ------------------------------//








//-------------------- 이메일 발송 s --------------------//
function wnw_mail($mail_from,$mail_from_name,$mail_to,$mail_subject,$mail_content){

	$nameFrom	= $mail_from_name ;
	$mailFrom	= $mail_from ;
	$nameTo		= "name";
	$mailTo = $mail_to ;
	// $cc = "참조";
	// $bcc = "숨은참조";
	$subject = $mail_subject ;
	$content = $mail_content ;

	$charset = "UTF-8";

	$nameFrom	= "=?$charset?B?".base64_encode($nameFrom)."?=";
	$nameTo		= "=?$charset?B?".base64_encode($nameTo)."?=";
	$subject	= "=?$charset?B?".base64_encode($subject)."?=";

	$header .= "Return-Path: <". $mailFrom .">\r\n";
	$header .= "From: ". $nameFrom ." <". $mailFrom .">\r\n";
//	$header .= "Reply-To: ". $mailFrom ."\r\n";

	if ($cc) $header .= "Cc: ". $cc ."\r\n";
	if ($bcc) $header .= "Bcc: ". $bcc ."\r\n";

	$header	.= "Content-Type: text/html; charset=". $charset . "\r\n";
	$header .= "MIME-Version: 1.0\r\n";
	$header .= "\r\n";

	// mail($mailTo, $subject, $content, $header, $mailFrom);
	mail($mailTo, $subject, $content, $header, '-f'.$mailFrom);

}
//-------------------- 이메일 발송 e --------------------//



// --------- title image s ---------------//
function calltitle($n) {
	$qstring = "select * from WENEEDWEB_TITLEIMG where TT_ok='Y' AND number='$n' " ;
	$result = mysqli_query($mysql_con,$qstring);
	$row = mysqli_fetch_array($result);

	$image = "<img src='../imgs/$row[TT_image]'>" ;
	if ( substr($row[TT_image],-3) == "swf" ) $image = "<script>WeneedwebflashExe('$row[TT_flash_size1]','$row[TT_flash_size2]','','','','high','transparent','','#FFFFFF','','','','/imgs/$row[TT_image]');</script>" ;
	return $image ;
}
// --------- title image e ---------------//





//-------------------- API s --------------------//
function callapi($url, $parameters) {
	$post_field_string = http_build_query($parameters, '', '&');
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field_string);
	curl_setopt($ch, CURLOPT_POST, true);
	$response = curl_exec($ch);
	// print_r($response);
	curl_close ($ch);
	return json_decode($response);
}
//-------------------- API e --------------------//





//-------------------- 확장자 추출 s --------------------//
function get_extentions($n) {
	 $ext = "" ;
	if ( $n == "image/pjpeg" ) $ext = "jpg" ;
	if ( $n == "image/jpeg" ) $ext = "jpg" ;
	if ( $n == "image/gif" ) $ext = "gif" ; //
	if ( $n == "image/x-png" ) $ext = "png" ;
	if ( $n == "image/png" ) $ext = "png" ; //
	if ( $n == "image/x-icon" )	$ext = "ico" ;

	if ( $n == "application/pdf" ) $ext = "pdf" ;
	if ( $n == "application/msword" ) $ext = "doc" ;
	if ( $n == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" ) $ext = "docx" ;
	if ( $n == "application/vnd.ms-powerpoint" ) $ext = "ppt" ; //
	if ( $n == "application/vnd.openxmlformats-officedocument.presentationml.presentation" ) $ext = "pptx" ;
	if ( $n == "application/vnd.ms-excel" ) $ext = "xls" ;
	// if ( $n == "application/octet-stream" ) $ext = "xls" ;
	if ( $n == "application/haansoftxls" ) $ext = "xls" ;
	if ( $n == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" ) $ext = "xlsx" ;
	if ( $n == "application/haansofthwp" ) $ext = "hwp" ;
	if ( $n == "text/plain" ) $ext = "txt" ;
	if ( $n == "application/zip" ) $ext = "zip" ;
	if ( $n == "application/x-zip-compressed" ) $ext = "zip" ;
	if ( $n == "audio/wav" ) $ext = "wav" ; //
	if ( $n == "audio/mp3" ) $ext = "mp3" ; //
	if ( $n == "audio/mpeg" ) $ext = "mp3" ;
	if ( $n == "audio/x-ms-wma" ) $ext = "wma" ;
	if ( $n == "video/mp4" ) $ext = "mp4" ; //
	if ( $n == "video/x-ms-wmv" ) $ext = "wmv" ;
	if ( $n == "video/avi" ) $ext = "avi" ; //

	return $ext ;
}
//-------------------- 확장자 추출 e --------------------//





//-------------------- 랜덤 생성 s --------------------//
function get_random_string($type = "", $len = 6){
	$lowercase = "abcdefghijklmnopqrstuvwxyz";
	$uppercase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$numeric = "0123456789";
	$special = '`~!@#$%^&*()-_=+\\|[{]};:\'",<.>/?';
	$key = "";
	$token = "";

	if($type == ""){
		$key = $lowercase.$uppercase.$numeric;
	}
	else{

		if(strpos($type,'09') > -1){
			$key .= $numeric;
		}

		if(strpos($type, 'az') > -1){
			$key .= $lowercase;
		}

		if(strpos($type, 'AZ') > -1){
			$key .= $uppercase;
		}

		if(strpos($type, '$') > -1){
			$key .= $special;
		}

	}

	for ($i = 0; $i < $len; $i++){
		$token .= $key[mt_rand(0, strlen($key) - 1)];
	}

	return $token;
}
//-------------------- 랜덤 생성 e --------------------//




//-------------------- 랜덤 생성 s --------------------//
function get_random_string20($type = "", $len = 20){
	$lowercase = "abcdefghijklmnopqrstuvwxyz";
	$uppercase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$numeric = "0123456789";
	$special = '`~!@#$%^&*()-_=+\\|[{]};:\'",<.>/?';
	$key = "";
	$token = "";

	if($type == ""){
		$key = $lowercase.$uppercase.$numeric;
	}
	else{

		if(strpos($type,'09') > -1){
			$key .= $numeric;
		}

		if(strpos($type, 'az') > -1){
			$key .= $lowercase;
		}

		if(strpos($type, 'AZ') > -1){
			$key .= $uppercase;
		}

		if(strpos($type, '$') > -1){
			$key .= $special;
		}

	}

	for ($i = 0; $i < $len; $i++){
		$token .= $key[mt_rand(0, strlen($key) - 1)];
	}

	return $token;
}
//-------------------- 랜덤 생성 e --------------------//







function send_alimtalk($tpl_code, $subject, $buttons, $kakao_msg, $phone, $name) {

/*
-----------------------------------------------------------------------------------
알림톡 전송
-----------------------------------------------------------------------------------
버튼의 경우 템플릿에 버튼이 있을때만 버튼 파라메더를 입력하셔야 합니다.
버튼이 없는 템플릿인 경우 버튼 파라메더를 제외하시기 바랍니다.
*/

global $aligo_id, $aligo_key, $token, $aligo_senderkey, $aligo_sender ;

$apikey		= $aligo_key ;
$userid		= $aligo_id ;
$senderkey	= $aligo_senderkey ;
$sender		= $aligo_sender ;

// $senddate	= date("YmdHis", strtotime("+10 minutes")) ; // 예약시에만 필요

$_apiURL	= 'https://kakaoapi.aligo.in/akv10/alimtalk/send/';
$_hostInfo	= parse_url($_apiURL);
$_port		= (strtolower($_hostInfo['scheme']) == 'https') ? 443 : 80;

$_variables = array(
	'apikey'		=> $apikey,
	'userid'		=> $userid,
	'token'			=> $token,
	'senderkey'		=> $senderkey,
	'tpl_code'		=> $tpl_code,
	'sender'		=> $sender,

	'receiver_1'	=> $phone,
	'recvname_1'	=> $name,
	'subject_1'		=> $subject,
	'message_1'		=> $kakao_msg,
	'button_1'		=> $buttons
);

$oCurl = curl_init();
curl_setopt($oCurl, CURLOPT_PORT, $_port);
curl_setopt($oCurl, CURLOPT_URL, $_apiURL);
curl_setopt($oCurl, CURLOPT_POST, 1);
curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($oCurl, CURLOPT_POSTFIELDS, http_build_query($_variables));
curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);

$ret = curl_exec($oCurl);
$error_msg = curl_error($oCurl);
curl_close($oCurl);

// 리턴 JSON 문자열 확인
// if ( $phone == "01032081688" ) print_r($ret . PHP_EOL);

// JSON 문자열 배열 변환
// $retArr = json_decode($ret);

// 결과값 출력
// print_r($retArr);

/*
code : 0 성공, 나머지 숫자는 에러
message : 결과 메시지
*/
}




//------------------------------ 숙소 판매가 계산해서 total 계산 s ------------------------------//
function call_order_KRW($number, $ap_order_number) {
global $mysql_con ;

$where = " where number='$number' " ;
if ( $ap_order_number ) $where = " where ap_order_number='$ap_order_number' " ;

$q = " select * from APPTABLE $where " ;
$r = mysqli_query($mysql_con,$q);
$R = mysqli_fetch_array($r);

$where2 = " where ap_order_number='$R[ap_order_number]' " ;
$q2 = " select * from APPTABLE2 $where2 " ;
$r2 = mysqli_query($mysql_con,$q2);
$rows2 = mysqli_num_rows($r2);

for ( $i = 1 ; $i <= $rows2 ; $i ++ ) {
$R2 = mysqli_fetch_array($r2);

	$ap2_cost_exchange = $R2[ap2_cost_exchange] ;				// 화폐단위
	$ap2_cost_exchange_value = str_replace(",","",$R2[ap2_cost_exchange_value]) ;	// 환율
	$ap2_cost_value = str_replace(",","",$R2[ap2_cost_value]) ;						// 금액
	$ap2_ea = $R2[ap2_ea] ;
	$ap2_N_real = $R2[ap2_N_real] ;

	$KRW = $ap2_cost_exchange_value * round($ap2_cost_value) ;
	if ( $ap2_cost_exchange == "VND" ) $KRW = round($KRW / 100) ;

	$KRW = $KRW * $ap2_ea * $ap2_N_real ;
	$total_KRW += $KRW ;
}

	//-------------------- 항공이 있으 ㄹ수 있으니 항공료 계산 추가 s --------------------//
	$where = " where ap_order_number='$R[ap_order_number]' " ;
	$qm1 = " select * from WENEEDWEB_MANS $where order by number asc " ;
	$rm1 = mysqli_query($mysql_con,$qm1);
	$rowsm1 = mysqli_num_rows($rm1);

	for ( $m = 0 ; $m < $rowsm1 ; $m ++ ) {
	$RM1 = mysqli_fetch_array($rm1);
		if ( strlen($RM1[M_air_birth]) == "7" && ( substr($RM1[M_air_birth],6,1) == "1" || substr($RM1[M_air_birth],6,1) == "2" || substr($RM1[M_air_birth],6,1) == "5" || substr($RM1[M_air_birth],6,1) == "6" ) ) $adult_ea ++ ;
		if ( strlen($RM1[M_air_birth]) == "7" && ( substr($RM1[M_air_birth],6,1) == "3" || substr($RM1[M_air_birth],6,1) == "4" || substr($RM1[M_air_birth],6,1) == "7" || substr($RM1[M_air_birth],6,1) == "8" ) ) $child_ea ++ ;
	}

	$total_KRW += $R[ap_FN_cost_adult] * $adult_ea ;
	$total_KRW += $R[ap_FN_cost_child] * $child_ea ;
	//-------------------- 항공이 있으 ㄹ수 있으니 항공료 계산 추가 e --------------------//

return $total_KRW*1 ;

}
//------------------------------ 숙소 판매가 계산해서 total 계산 e ------------------------------//










//------------------------------ 숙소 원가 계산해서 total 계산 s ------------------------------//
function call_order_net_KRW($number, $ap_order_number) {
global $mysql_con ;

$where = " where number='$number' " ;
if ( $ap_order_number ) $where = " where ap_order_number='$ap_order_number' " ;

$q = " select * from APPTABLE $where " ;
$r = mysqli_query($mysql_con,$q);
$R = mysqli_fetch_array($r);

$where2 = " where ap_order_number='$R[ap_order_number]' " ;
$q2 = " select * from APPTABLE2 $where2 " ;
$r2 = mysqli_query($mysql_con,$q2);
$rows2 = mysqli_num_rows($r2);

for ( $i = 1 ; $i <= $rows2 ; $i ++ ) {
$R2 = mysqli_fetch_array($r2);

	$ap2_net_exchange = $R2[ap2_net_exchange] ;				// 화폐단위
	$ap2_net_exchange_value = str_replace(",","",$R2[ap2_net_exchange_value]) ;	// 환율
	$ap2_net_value = str_replace(",","",$R2[ap2_net_value]) ;						// 금액
	$ap2_ea = $R2[ap2_ea] ;
	$ap2_N_real = $R2[ap2_N_real] ;

	$KRW = $ap2_net_exchange_value * round($ap2_net_value) ;
	if ( $ap2_net_exchange == "VND" ) $KRW = round($KRW / 100) ;

	$KRW = $KRW * $ap2_ea * $ap2_N_real ;
	$total_KRW += $KRW ;
}

	//-------------------- 항공이 있으 ㄹ수 있으니 항공료 계산 추가 s --------------------//
	$where = " where ap_order_number='$R[ap_order_number]' " ;
	$qm1 = " select * from WENEEDWEB_MANS $where order by number asc " ;
	$rm1 = mysqli_query($mysql_con,$qm1);
	$rowsm1 = mysqli_num_rows($rm1);

	for ( $m = 0 ; $m < $rowsm1 ; $m ++ ) {
	$RM1 = mysqli_fetch_array($rm1);
		if ( strlen($RM1[M_air_birth]) == "7" && ( substr($RM1[M_air_birth],6,1) == "1" || substr($RM1[M_air_birth],6,1) == "2" || substr($RM1[M_air_birth],6,1) == "5" || substr($RM1[M_air_birth],6,1) == "6" ) ) $adult_ea ++ ;
		if ( strlen($RM1[M_air_birth]) == "7" && ( substr($RM1[M_air_birth],6,1) == "3" || substr($RM1[M_air_birth],6,1) == "4" || substr($RM1[M_air_birth],6,1) == "7" || substr($RM1[M_air_birth],6,1) == "8" ) ) $child_ea ++ ;
	}

	$total_KRW += $R[ap_FN_cost_adult_net] * $adult_ea ;
	$total_KRW += $R[ap_FN_cost_child_net] * $child_ea ;
	//-------------------- 항공이 있으 ㄹ수 있으니 항공료 계산 추가 e --------------------//

return $total_KRW*1 ;

}
//------------------------------ 숙소 판매가 계산해서 total 계산 e ------------------------------//









//------------------------------ 송금액 계산 s ------------------------------//
function call_order_transfer_KRW($number, $ap_order_number) {
global $mysql_con ;

$where = " where number='$number' " ;
if ( $ap_order_number ) $where = " where ap_order_number='$ap_order_number' " ;

$q = " select * from APPTABLE $where " ;
$r = mysqli_query($mysql_con,$q);
$R = mysqli_fetch_array($r);

$where2 = " where ap_order_number='$R[ap_order_number]' " ;
$where2.= " AND ap2_transfer_date is not NULL " ;
$q2 = " select * from APPTABLE2 $where2 " ;
$r2 = mysqli_query($mysql_con,$q2);
$rows2 = mysqli_num_rows($r2);

for ( $i = 1 ; $i <= $rows2 ; $i ++ ) {
$R2 = mysqli_fetch_array($r2);

	$ap2_transfer_exchange = $R2[ap2_transfer_exchange] ;				// 화폐단위
	$ap2_transfer_exchange_value = str_replace(",","",$R2[ap2_transfer_exchange_value]) ;	// 환율
	$ap2_net_value = str_replace(",","",$R2[ap2_net_value]) ;						// 금액
	$ap2_ea = $R2[ap2_ea] ;
	$ap2_N_real = $R2[ap2_N_real] ;

	$KRW = $ap2_transfer_exchange_value * round($ap2_net_value) ;
	if ( $ap2_transfer_exchange == "VND" ) $KRW = round($KRW / 100) ;

	$KRW = $KRW * $ap2_ea * $ap2_N_real ;
	$total_KRW += $KRW ;
}

return $total_KRW*1 ;

}
//------------------------------ 송금액 계산 e ------------------------------//





//------------------------------ 담당자 불러오기 s ------------------------------//
function call_manager($MD_id, $user_id) {

global $mysql_con ;

	if ( !$MD_id ) $MD_id = "0000" ;

	$where = " where MD_id='$MD_id' " ;
	$where.= " AND user_id='$user_id' " ;
	$q = " select name from WORKMAN $where order by number desc limit 1 " ;
	$r = mysqli_query($mysql_con,$q);
	$R = mysqli_fetch_array($r);

	return $R[0] ;
}
//------------------------------ 담당자 불러오기 e ------------------------------//





function call_pay($number) {

	global $mysql_con ;

	$q = " select * from APPTABLE where number='$number' " ;
	$r = mysqli_query($mysql_con, $q);
	$R = mysqli_fetch_array($r);

	$qstring = " select * from APPPAY where ap_order_number='$R[ap_order_number]' order by P_pay_day asc " ;
	$result = mysqli_query($mysql_con, $qstring);
	$rows = mysqli_num_rows($result);

	for ( $j = 0 ; $j < $rows ; $j ++ ) {
	$R = mysqli_fetch_array($result);

		$P_pay_day = substr($R[P_pay_day],0,16) ;

		if ( $R[P_type] == "1" ) {
			$total_incom += $R[P_pay] ;
			$total = round($total) - round($R[P_pay]) ;
		}
		if ( $R[P_type] == "2" ) {
			$total_outcom += $R[P_pay] ;
			$total = round($total) + round($R[P_pay]) ;
		}

	}

	return round($total_incom - $total_outcom) ;
}




function getManNai($YMD_flag,$birth){
	$birth = explode("-",$birth);

	$Y = $birth[0] ;
	$M = $birth[1] ;
	$D = $birth[2] ;

	if ( $YMD_flag ) {
		$YMD_flag = explode("-",$YMD_flag);
		$now_year = $YMD_flag[0] ;
		$now_month = $YMD_flag[1] ;
		$now_day = $YMD_flag[2] ;
	} else {
		$now_year = date("Y");
		$now_month = date("m");
		$now_day = date("d");
	}

	if ( $M < $now_month ){
		$age = $now_year - $Y;
	} else if ( $M == $now_month){
		if($D <= $now_day) {
			$age = $now_year - $Y;
		} else {
			$age = $now_year - $Y -1;
		}
	}else{
		$age = $now_year - $Y-1;
	}
	return $age;
}
?>
