<?php
//업로드파일 제한
$prohibit_ext = array('php', 'php4', 'php5', 'phtml', 'asp', 'aspx', 'java', 'jsp', 'html', 'htm', 'cgi', 'exe', 'inc', 'pl', 'dll', 'lib', 'js');
$image_ext = array('gif', 'jpg', 'jpeg', 'png', 'ico');
$excel_ext = array('xls', 'xlsx', 'csv');

//빈문자열여부 체크
function check_str($val, $default_val){
	$val = check_injection($val);

	if(is_null($val) == true){
		$val = "";
	}

	if(trim($val) == ""){
		$rtn_val = $default_val;
	}
	else{
		$rtn_val = $val;
	}

	return $rtn_val;
}

//숫자 여부 체크
function check_int($val, $default_val){
	$val = check_injection($val);

	if(is_null($val) == true){
		$val = "";
	}

	if(trim($val) == ""){
		$rtn_val = $default_val;
	}
	else{

		if(is_numeric($val) == true){
			$rtn_val = $val;
		}
		else{
			echo "
			<script type=\"text/javascript\">
			alert('잘못된 데이터가 넘어 왔습니다.');
			history.back();
			</script>
			";
			exit;
		}

	}

	return $rtn_val;
}

//따옴표(인용) 제거
function get_remove_quotation($val){
	$val = str_replace("\"", "", $val);
	$val = str_replace("&#034;", "", $val);
	$val = str_replace("'", "", $val);
	$val = str_replace("&#039;", "", $val);

	return $val;
}

//줄바꿈
function get_br($val){

	if(trim($val) != "" && strlen($val) > 0){
		$val = str_replace(' ', '&nbsp;', $val);
		$val = nl2br($val);
	}
								
	return $val;
}

//글자수 자르기
function str_cut($val, $cut_size){

	if($cut_size <= 0){
		return $val;
	}

	for($i = 0; $i < $cut_size; $i++){
						
		if(ord($val[$i]) > 127){
			$han++;
		}	
		else{
			$eng++;
		}
			
	}
			
	$cut_size = $cut_size + (int)$han * 0.6;
	$point = 1;

	for($i = 0; $i < strlen($val); $i++){
										
		if($point > $cut_size){
			return $tmp_point . "..";
		}

		if(ord($val[$i]) <= 127){
			$tmp_point .= $val[$i];

			if($point % $cut_size == 0){
				return $tmp_point . ".."; 
			}

		} 
		else{

			if($point % $cut_size == 0){
				return $tmp_point . "..";
			}

			$tmp_point .= $val[$i] . $val[++$i];
			$point++;
		}

		$point++;
	}

	return $tmp_point;
}

//물리적경로
function get_real_filepath($filepath){
	$real_filepath = $_SERVER['DOCUMENT_ROOT'] . $filepath;
	return $real_filepath;
}

//폴더생성
function make_folder($filepath){
	umask(0);
	$real_filepath = $_SERVER['DOCUMENT_ROOT'] . $filepath;

	if(!is_dir($real_filepath)){
		mkdir($real_filepath, 0777, true);
	}

}

//파일이름
function get_filename($filepath, $ext){
	$filename = time() . "." . $ext;
	$i = 1;

	do{
		 
		if(file_exists($_SERVER['DOCUMENT_ROOT'] . $filepath . DIRECTORY_SEPARATOR . $filename)){
			$filename = time() . "." . $ext;
		}
		else{
			$i = $i + 1;
		}

	}
	while($i == 1);

	return $filename;
}

//파일이름2
function get_filename2($filepath, $only_filename, $ext){
	$filename = $only_filename . "." . $ext;
	$i = 2;

	do{
		 
		if(file_exists($_SERVER['DOCUMENT_ROOT'] . $filepath . DIRECTORY_SEPARATOR . $only_filename . '.' . $ext)){
			$filename = $only_filename . "_" . $i . "." . $ext;
		}
		else{
			$i = $i + 1;
		}

	}
	while($i == 2);

	return $filename;
}

//폴더삭제(하위폴더,파일 포함)
function delete_dir($dir){
	
	if(is_dir($dir)){
		$dirs = dir($dir);

		while(false !== ($entry = $dirs->read())){

			if($entry != "." && $entry != ".."){
			
				if(is_dir($dir . DIRECTORY_SEPARATOR . $entry)){
					delete_dir($dir . DIRECTORY_SEPARATOR . $entry);
				} 
				else{
					unlink($dir . DIRECTORY_SEPARATOR . $entry);
				}
		
			}
	   
	   }
	   
	   $dirs->close();
	   rmdir($dir);
	}

}

//파일 삭제
function delete_file($filepath, $filename){

	if($filename != "" && file_exists(get_real_filepath($filepath) . DIRECTORY_SEPARATOR . $filename)){
		unlink(get_real_filepath($filepath) . DIRECTORY_SEPARATOR . $filename);
	}

}

function delete_file2($filename){

	if(!is_dir($filename) && $filename != "" && file_exists(get_real_filepath($filename))){
		unlink(get_real_filepath($filename));
	}

}

//첫번째 폴더명 추출
function get_first_folder(){
	$dir = dirname($_SERVER['SCRIPT_NAME']);
	$arr_dir = explode('/', $dir);
	$folder_name = $arr_dir[1];

	return $folder_name;
}

//현재 폴더명 추출
function get_folder_name(){
	$dir = dirname($_SERVER['PHP_SELF']); 
	$pos = strrpos($dir, '/'); 
	$folder_name = substr($dir, $pos + 1);
					
	return $folder_name;
}

function get_folder(){
	$dir = substr(dirname($_SERVER['SCRIPT_NAME']), 1);
	$pos = strrpos($dir, '/'); 
	$folder_name = substr($dir, $pos);

	return $folder_name;
}

//파일명 추출
function get_only_filename($filename){
	$pos = strrpos($filename, '.'); 
	$only_filename = substr($filename, 0, $pos);
								
	return $only_filename;
}

//파일 확장자 추출
function get_ext($filename){
	$pos = strrpos($filename, '.'); 
	$ext = substr($filename, $pos + 1);
								
	return $ext;
}

function iconv_to_utf8($val){ 
	$val = iconv('cp949', 'utf-8', $val);
	return $val; 
} 

function iconv_to_euckr($val){ 
	$val = iconv('utf-8', 'cp949', $val);
	return $val; 
} 

//한글파일이름 숫자로 전환
function get_h_filename($only_filename, $ext){
	$han = 0;

	for($i = 0; $i <= strlen($only_filename); $i++){    

		if(ord($only_filename[$i]) > 127){
			$han++;
			break;
		}

	}

	if($han > 0){
		$filename = "h_" . time() . "." . $ext;
	}
	else{
		$filename = $only_filename . "." . $ext;
	}

	return $filename;
}

//금지파일체크
function check_ext($ext){
	$prohibit_ext = array('php', 'php4', 'php5', 'phtml', 'asp', 'aspx', 'java', 'jsp', 'html', 'htm', 'cgi', 'exe', 'inc', 'pl', 'dll', 'lib', 'js');

	if(in_array($ext, $prohibit_ext)){
		alertError('not_upload');
	}

}

//금지파일체크2
function check_ext2($ext){
	$prohibit_ext = array('php', 'php4', 'php5', 'phtml', 'asp', 'aspx', 'java', 'jsp', 'html', 'htm', 'cgi', 'exe', 'inc', 'pl', 'dll', 'lib', 'js');

	if(in_array($ext, $prohibit_ext)){
		$alert_msg = "업로드할 수 없는 파일입니다.";
		OnlyErrmsg($alert_msg);
		exit;
	}

}

//값이 공백인 경우 0 으로 처리
function get_cint($val){
   
	if(is_null($val) == true || $val == ""){
		$rtn_val = 0;
	}
	else{
		$rtn_val = $val;
	}

	return $rtn_val;
}

//select box에서 cint 변환시 값을 없을 경우 -1로 처리
function get_sel_cint($val){
   
	if($val == ""){
		$rtn_val = -1;
	}
	else{
		$rtn_val = $val;
	}

	return $rtn_val;
}

//integer타입 값이 없을 경우 0값을 리턴
function get_zero($val){

	if($val == ""){
		$val = 0;
	}
								
	return $val;
}

//integer타입 값이 0일 경우 공백값을 리턴
function get_empty($val){

	if($val <= 0){
		$val = "";
	}
								
	return $val;
}

//replace
function get_replace($replace1, $replace2, $val){
	$rtn_val = "";

	if($val != ""){
		$rtn_val = str_replace($replace1, $replace2, $val);
	}
	
	return $rtn_val;
}

//휴대폰번호 체크
function check_hp($val){
	$rtn_val = "N";
	//$val = str_replace("-", "", $val);

	//$val = ereg_replace("[^0-9]", "", $val);
	//$val = preg_replace("/[^0-9]/", "", $val);
	$val_pattern = "/^(010|011|016|017|018|019)-\d{3,4}-\d{4}$/u";
	//$val_pattern = "/^(010|011|016|017|018|019)\d{3,4}\d{4}$/u";

	if(preg_match($val_pattern, $val)){  //휴대폰번호가 아니거나 형식이 틀릴경우 빠져나가기
		$rtn_val = "Y";
	}

	return $rtn_val;
}

//메일보내기
function send_mail($mailname, $mailfrom, $mailto, $mailtitle, $mailcontent, $filepath = "", $origin_filename = "", $filename = "", $filetype = ""){
	$mailname = iconv_to_euckr($mailname);
	$mailtitle = iconv_to_euckr($mailtitle);
	$mailcontent = iconv_to_euckr($mailcontent);
	$origin_filename = iconv_to_euckr($origin_filename);

	$boundary = "----" . uniqid("part"); //구분자 생성

	//--- 헤더작성 ---//
	$header  = "Return-Path: $mailfrom\r\n"; //반송 이메일 주소
	$header .= "from: $mailname <$mailfrom>\r\n"; //송신자명, 송신자 이메일 주소

	//--- 첨부화일이 있을경우 ---//
	if($filename != "" && file_exists(get_real_filepath($filepath) . DIRECTORY_SEPARATOR . $filename)){
		$sendfile = get_real_filepath($filepath) . DIRECTORY_SEPARATOR . $filename;
		$filesize = filesize(get_real_filepath($filepath) . DIRECTORY_SEPARATOR . $filename);
/*
		echo "sendfile - " . $sendfile . "<br />";
		echo "origin_filename - " . $origin_filename . "<br />";
		echo "filesize - " . $filesize . "<br />";
		echo "filetype - " . $filetype . "<br />";
		exit;
*/
		$fp = fopen($sendfile, "r"); //파일 열기
		$file = fread($fp, $filesize); //파일 읽기
		fclose($fp); //파일 닫기
	
		if($filetype == ""){
			$filetype = "application/octet-stream";
		}

		//--- 헤더작성 ---//
		$header .= "MIME-Version: 1.0\r\n"; //MIME 버전 표시
		$header .= "Content-Type: Multipart/mixed; boundary=\"$boundary\""; //구분자 설정, Multipart/mixed 일 경우 첨부화일

		//--- 이메일 본문 생성 ---//
		$mailbody = "This is a multi-part message in MIME format.\r\n\r\n";
		$mailbody .= "--$boundary\r\n";
		$mailbody .= "Content-Type: text/html; charset=euc-kr\r\n";
		$mailbody .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
		$mailbody .= $mailcontent . PHP_EOL;

		//--- 파일 첨부 ---//
		$mailbody .= "--$boundary\r\n"; 
		$mailbody .= "Content-Type: ".$filetype."; name=\"".$origin_filename."\"\r\n"; //내용
		$mailbody .= "Content-Transfer-Encoding: base64\r\n"; //암호화 방식 
		$mailbody .= "Content-Disposition: attachment; filename=\"".$origin_filename."\"\r\n\r\n"; //첨부파일인 것을 알림
		$mailbody .= base64_encode($file) . "\r\n\r\n"; 

		$mailbody .= "--$boundary--"; //내용 구분자 마침
	} 
	else{
		//--- 헤더작성 ---//
		$header .= "MIME-Version: 1.0\r\n"; 
		$header .= "Content-Type: Multipart/alternative; boundary = \"$boundary\""; 

		//--- 이메일 본문 생성 ---//
		$mailbody = "--$boundary\r\n"; 
		$mailbody .= "Content-Type: text/html; charset=euc-kr\r\n";
		$mailbody .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
		$mailbody .= $mailcontent . PHP_EOL;

		$mailbody .= "--$boundary--\r\n\r\n"; 
	} 

	mail($mailto, $mailtitle, $mailbody, $header);
/*
	$result = mail($mailto, $mailtitle, $mailbody, $header);

	if($result){
		echo "Succeed";
	}
	else{
		echo "Failed";
	}
*/
}

//소수점 체크 및 표시
function get_decimal_point($val = 0, $cnt){
	$rtn_val = "";

	if($val != "" && $val > 0){

		if(preg_match("/\./", $val)){ 
			$rtn_val = number_format($val, $cnt);
		} 
		else{
			$rtn_val = number_format($val);
		}

	}

	return $rtn_val;
}

//최근 게시물 표시(new 아이콘)
function get_new_icon($regdate, $new_article = 24){
	//$time_limit = date('Y-m-d H:i:s', strtotime('-72 hour', time()));
	$time_limit = date('Y-m-d H:i:s', strtotime('-$new_article hour', time()));

	if($regdate > $time_limit){
		echo "&nbsp;<img src=\"/images/ico_new_s.jpg\" />";
	}

}

//리스트 댓글 카운트
function get_as_admin_cmt_cnt($cmt_cnt = 0){

	if($cmt_cnt > 0){
		$cmt_cnt = as_number_format($cmt_cnt);
		echo "&nbsp;<span style=\"color:#660000;\"><strong>[$cmt_cnt]</strong></span>";
	}

}

//리스트 댓글 카운트
function get_as_cmt_cnt($cmt_cnt = 0){

	if($cmt_cnt > 0){
		$cmt_cnt = as_number_format($cmt_cnt);
		echo "<span style=\"color:#660000; position:relative; top:-1px;\"><strong>[$cmt_cnt]</strong></span>&nbsp;";
	}

}

//비밀글
function get_admin_secret_icon($secret_YN = ""){

	if($secret_YN == "Y"){
		echo "<img src=\"/images/common/ico_secret_Y.gif\" style=\"position:relative; top:2px;\" />&nbsp;";
	}

}

function get_secret_icon($secret_YN = ""){

	if($secret_YN == "Y"){
		echo "<img src=\"/images/common/ico_secret_Y.gif\" style=\"position:relative; top:-2px;\" />&nbsp;";
	}

}

function get_main_secret_icon($secret_YN = ""){

	if($secret_YN == "Y"){
		echo "<img src=\"/images/common/ico_secret_Y.gif\" style=\"position:absolute; top:0; right:0;\" />";
	}

}

function set_select($select_val, $db_val = ""){
	$rtn_val = "";

	if($db_val != ""){

		if($select_val == $db_val){
			$rtn_val = " selected=\"selected\"";
		}

	}

	return $rtn_val;
}

function set_checkbox($checkbox_val, $db_val = ""){

	if(is_array($db_val) == true){

		foreach($db_val as $val){ 

			if($checkbox_val == $val){
				echo " checked=\"checked\"";
				break;
			}

		}

	}
	else{

		if($checkbox_val == $db_val){
			echo " checked=\"checked\"";
		}

	}

}

function set_radio($radio_val, $db_val = ""){
	$rtn_val = "";

	if($db_val != ""){

		if($radio_val == $db_val){
			$rtn_val = " checked=\"checked\"";
		}

	}

	return $rtn_val;
}

function get_image($val = ""){ 
    $rtn_array = array(); 

	$pattern = "/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i"; 
     
    $matches = array(); 
    preg_match_all($pattern, $val, $matches); 

	//$filepath = str_replace('www.', '', $matches[1]);
	$filepath = str_replace('http://' . $http_host, '', $matches[1]);

    //디버깅 코드 시작 
/*
    echo "<pre>"; 
    $array_val = print_r($matches, true); 
    echo str_replace("<", "<", $array_val); 
     
    print_r($matches[1]); 
    echo "</pre>"; 
*/
    //디버깅 코드 끝 
     
    //checks array size 
    if(sizeof($matches) > 0){ 
        //$rtn_array = $matches[1]; 
		$rtn_array = $filepath; 
    } 

    return $rtn_array; 
} 

//두 날짜 일차이 계산
function get_diff_day($edate, $sdate){
	//86400 (60초 * 60분 * 24시) 1일 초 환산
	$diff_day = intval((strtotime($edate) - strtotime($sdate)) / 86400);

	return $diff_day;
}

//두 날짜 월차이 계산
function get_diff_month($val = ""){
	$now_ym = date('Y-m');
	$arr_now_ym = explode('-', $now_ym);
	$now_year = $arr_now_ym[0];
	$now_month = $arr_now_ym[1];
	//echo "now_year - " . $now_year . "<br />";
	//echo "now_month - " . $now_month . "<br />";
	
	$val = substr($val, 0, 7);
	$arr_val = explode('-', $val);
	$val_year = $arr_val[0];
	$val_month = $arr_val[1];
	//echo "val_month - " . $val_year . "<br />";
	//echo "val_month - " . $val_month . "<br />";

	$diff_month = ($now_year - $val_year) * 12 + $now_month - $val_month; 

	return $diff_month;
}

//해당월 마지막 날짜
function get_month_lastday($year, $month){
	return date('t', mktime(0, 0, 0, $month, 1, $year));
}

//요일 구하기
function get_week($i, $this_date){
	$weekday = array('일', '월', '화', '수', '목', '금', '토');
	$rtn_val = $weekday[strftime('%w', strtotime('+$i day', strtotime($this_date)))];

	return $rtn_val;
}

//썸네일
function get_thumbnail($origin_filepath, $save_filepath, $max_width, $max_height){
	//$gijoon = $max_width;  //퀄리티 조절
	$ext = strtolower(get_ext($origin_filepath));

	if($ext == "jpg" || $ext == "jpeg"){
		$src_img = ImageCreateFromJPEG($origin_filepath); //JPG파일로부터 이미지를 읽어옵니다
	}
	else if($ext == "gif"){
		$src_img = ImageCreateFromGIF($origin_filepath);
	}
	else if($ext == "png"){
		$src_img = ImageCreateFromPNG($origin_filepath);
	}

	$image_info = getImageSize($origin_filepath);	//원본이미지의 정보를 얻어옵니다
	$image_width = $image_info[0];
	$image_height = $image_info[1];

	/* 썸네일 가로,세로 비율에 맞게 축소
	if(($image_width / $max_width) == ($image_height / $max_height)){	//원본과 썸네일의 가로,세로비율이 같은경우		
		$dst_width = $max_width;
		$dst_height = $max_height;
	}
	else if(($image_width / $max_width) < ($image_height / $max_height)){	//세로에 기준을 둔경우		
		$dst_width = $max_height * ($image_width / $image_height);
		$dst_height = $max_height;
	}
	else{	//가로에 기준을 둔경우		
		$dst_width = $max_width;
		$dst_height = $max_width * ($image_height / $image_width);
	}
	
	//그림사이즈를 비교해 원하는 썸네일 크기이하로 가로세로 크기를 설정합니다.
	*/

	$dst_width = $max_width;
	$dst_height = $max_height;

	//가로에 기준을 둔경우
	//$dst_width = $gijoon;
	//$dst_height = ceil($image_height * ($gijoon / $image_width));  //위쪽 가로기준 보다 이게 맞음

	$dst_img = imagecreatetruecolor($dst_width, $dst_height); //타겟이미지를 생성합니다
	//ImageCopyResized($dst_img, $src_img, 0, 0, 0, 0, $dst_width, $dst_height, $image_width, $image_height); //타겟이미지에 원하는 사이즈의 이미지를 저장합니다
	@ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $dst_width, $dst_height, imagesx($src_img), imagesy($src_img)); //ImageCopyResized 더 나은 퀄리티
	@ImageInterlace($dst_img);

	if($ext == "jpg" || $ext == "jpeg"){
		ImageJPEG($dst_img, $save_filepath, 9); //실제로 이미지파일을 생성합니다(숫자는 퀄리티인데요, 높을수록 용량크고 질이 좋아집니다.)
	}
	else if($ext == "gif"){
		ImageGIF($dst_img, $save_filepath, 9);
	}
	else if($ext == "png"){
		ImagePNG($dst_img, $save_filepath, 9); //png 퀄리티는 0~9까지
	}

	@ImageDestroy($dst_img);
	@ImageDestroy($src_img);
}

//1302522466 형태의 timestamp를 2011-04-11 20:47:46 형태의 날짜로 반환
function time2date($time){
	$date = date('Y-m-d H:i:s', $time);
	return $date;
} 

//2011-04-11 20:47:46 형태의 날짜를 1302522466 형태의 timestamp로 반환
function date2time($date){
	$arg = explode(' ', $date); //날짜 와 시간을 분리
	$ymd = explode('-', $arg[0]); //날짜 부분
	$hms = explode(':', $arg[1]); //시간 부분
	$time = mktime($hms[0], $hms[1], $hms[2], $ymd[1], $ymd[2], $ymd[0]);
	return $time;
}

//YYYYMMDDHHMMSS => YYYY-MM-DD HH:MM:SS 변환
function get_dateformat($date){
	$date_len = strlen($date);

	if($date_len >= 8){
		$year = substr($date, 0, 4);
		$month = substr($date, 4, 2);
		$day = substr($date, 6, 2);

		$dateformat = $year . "-" . $month . "-" . $day;
	}

	if($date_len >= 9){
		$hour = substr($date, 8, 2);
		$minute = substr($date, 10, 2);

		$dateformat .= " " . $hour . ":" . $minute;
	}

	if($date_len >= 13){
		$second = substr($date, 12, 2);
	
		$dateformat .= ":" . $second;
	}

	return $dateformat;
}

//배열 요소 삭제
function get_array_delete($arr, $del_arr){ //배열, 삭제할 값

	if(in_array($del_arr, $arr)){
		$key = array_search($del_arr, $arr); //배열에 키를 알아오고
		array_splice($arr, $key, 1); //배열에서 위에서 받아온 키를 삭제
	}

	//print_r($arr);
	return $arr;
}

//get_unpack($_SERVER[QUERY_STRING], "제외할 파라미터 복수의 파라미터는 (,)를 구분자로 사용");
function get_pack($params, $name = null){
	$rtn_val = "";
	$i = 0;

	foreach($params as $key => $val){

		if(is_array($val)){

			if($name == null){
				$rtn_val .= get_pack($val, $key);
			}
			else{
				$rtn_val .= get_pack($val, $name . "[$key]");   
			}

		} 
		else{

			if($name != null){
				$rtn_val .= $name . "[]" . "=$val";
			}
			else{
				$rtn_val .= "$key=$val";
			}

			if($i < count($params) - 1){
				$rtn_val .= "&";
			}

		}

		$i++;
	}

	return $rtn_val;
}

function get_unpack($query_string, $exception = ""){
	$exception = preg_replace("/[\s]+/", "", $exception);

	if($exception){
		parse_str($query_string, $qs);
		$newqs = array();

		foreach($qs as $k => $v){

			if(array_search($k, preg_split("/,/", $exception)) === false){
				$newqs[$k] = $v;
			}

		}

		return get_pack($newqs);
	} 
	else{
		return $query_string;
	}

}

//한글만 인코딩
function get_han_encode($str){
    preg_match_all("/[\x{1100}-\x{11ff}\x{3130}-\x{318f}\x{ac00}-\x{d7af}]+/u", $str, $matches);
     
    foreach($matches as $key2 => $val2){
        $cnt = count($val2);

        if($cnt > 0){

            foreach($val2 as $key3 => $val3){
                $str = str_replace($val3, urlencode($val3), $str);
            }

        }

    }

    return $str;
}

//실행시간
function get_microtime(){
    list($usec, $sec) = explode(' ', microtime());
    return ((float)$usec + (float)$sec);
}

//이전내용, 수정내용을 비교하여 이전내용의 이미지가 수정내용에서 이미지가 없을 경우 삭제
function diff_pre_editor_image_delete($pre_content = "", $now_content = ""){
	//echo $pre_content . "<br />";
	//echo $content . "<br />";

	$pre_image = get_image($pre_content);
	$pre_image_cnt = sizeof($pre_image);

	if($pre_image_cnt > 0){
		$arr_pre_editor_filepath = array();

		for($i = 0; $i < $pre_image_cnt; $i++){
			$editor_filepath = $pre_image[$i];
			//echo "editor_filepath : " . $editor_filepath . "<br />";
			$arr_pre_editor_filepath[$i] = $editor_filepath;
			//echo "이전 이미지 : " . $arr_pre_editor_filepath[$i] . "<br />";

		}

		//수정 에디터 이미지 시작
		$now_image = get_image($now_content); 
		$now_image_cnt = sizeof($now_image);

		if($now_image_cnt > 0){
			$arr_editor_filepath = array();

			for($i = 0; $i < $now_image_cnt; $i++){
				$editor_filepath = $now_image[$i];
				//echo "editor_filepath : " . $editor_filepath . "<br />";
				$arr_editor_filepath[$i] = $editor_filepath;
				//echo "수정 이미지 : " . $arr_editor_filepath[$i] . "<br />";
			}

		}

		//이전내용, 수정내용을 비교하여 이전내용의 이미지가 수정내용에서 이미지가 없을 경우 삭제
		$max_now_image_cnt = $pre_image_cnt >= $now_image_cnt ? $pre_image_cnt : $now_image_cnt;

		if($now_image_cnt > 0){	//수정내용에 이미지가 있을 경우
			$arr_diff_image = array_diff($arr_pre_editor_filepath, $arr_editor_filepath);
		}
		else{
			$arr_diff_image = $arr_pre_editor_filepath;
		}

		//echo "arr_diff_image : " . sizeof($arr_diff_image) . "<br />";

		if(sizeof($arr_diff_image) > 0){

			for($i = 0; $i < $max_now_image_cnt; $i++){

				if($arr_diff_image[$i] != ""){
					//echo "삭제 이미지 : " . $arr_diff_image[$i] . "<br />";
					delete_file2($arr_diff_image[$i]);
				}

			}

		}

	}

}

//게시물 삭제시 에디터 이미지삭제
function editor_image_delete($content = ""){
	$image = get_image($content);
	$image_cnt = sizeof($image);

	if($image_cnt > 0){
		$arr_editor_filepath = array();

		for($i = 0; $i < $image_cnt; $i++){
			$editor_filepath = $image[$i];
			//echo "editor_filepath : " . $editor_filepath . "<br />";
			$arr_editor_filepath[$i] = $editor_filepath;
			//echo "삭제 이미지 : " . $arr_editor_filepath[$i] . "<br />";
			delete_file2($arr_editor_filepath[$i]);
		}

	}

}

//접속구분(pc, hp)
function get_device_divi(){
	$rtn_val = "";
	$hp_agent = "/(iphone|ipod|ipad|android|blackberry|opera Mini|windows ce|nokia|sony|lgtelecom|skt|SymbianOS|SCH-M\d+|SonyEricsson|webOS)/i";

	if(preg_match($hp_agent, $_SERVER['HTTP_USER_AGENT'])){	
		$rtn_val = "hp";
	}
	else{
		$rtn_val = "pc";
	}

	return $rtn_val;
}

//접속아이피
function get_userip(){

	if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']){
		$userip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} 
	else{
		$userip = $_SERVER['REMOTE_ADDR'];
	}

	return $userip;
}

//파일용량 표시
function get_str_filesize($filesize){

    if($filesize > 1024000000){
		$str_filesize = round((double)($filesize) / 1024000000, 1) . " GByte";
	}
	else if($filesize > 1024000){
		$str_filesize = round((double)($filesize) / 1024000, 1) . " MByte";
	}
	else if($filesize > 1024){
		$str_filesize = round((double)($filesize) / 1024, 1) . " KByte";
	}
	else{
		$str_filesize = $filesize . " Byte";
	}

	return $str_filesize;
}

//파일용량 표시2
function get_str_filesize2($filesize){

	switch($filesize){
		case "1024000" :
			$str_filesize = "1 MByte";
			break;
		case "2048000" :
			$str_filesize = "2 MByte";
			break;
		case "3072000" :
			$str_filesize = "3 MByte";
			break;
		case "4096000" :
			$str_filesize = "4 MByte";
			break;
		case "5120000" :
			$str_filesize = "5 MByte";
			break;
		case "10240000" :
			$str_filesize = "10 MByte";
			break;
		case "20480000" :
			$str_filesize = "20 MByte";
			break;
		case "30720000" :
			$str_filesize = "30 MByte";
			break;
		case "40960000" :
			$str_filesize = "40 MByte";
			break;
		case "51200000" :
			$str_filesize = "50 MByte";
			break;
	}

	return $str_filesize;
}

//날짜 유효성체크
function validate_date($date, $format = "Y-m-d"){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

//배열에서 원하는 값에 배열만 제거하기
function arr_del($arr_list, $arr_del){ //배열, 삭제할 값
	$key = array_search($arr_del, $arr_list); //배열에 키를 알아오고
	array_splice($arr_list, $key, 1); //배열에서 위에서 받아온 키를 삭제
	
	return $arr_list;
}

//비밀번호 암호화
function get_hash($passwd){
	//echo "PHP_VERSION - " . PHP_VERSION . "<br />";

	if(version_compare(PHP_VERSION, '5.3.7') >= 0){

		if(function_exists('password_hash')){	//php 5.5 이상
			$hash = password_hash($passwd, PASSWORD_DEFAULT); //암호화 
		}
		else{
			include_once $_SERVER['DOCUMENT_ROOT'] . "/common/lib/password.php";
			$hash = password_hash($passwd, PASSWORD_DEFAULT); //암호화 
		}

	}
	else{
		include_once $_SERVER['DOCUMENT_ROOT'] . "/common/lib/password_hash.php";
		$hash = create_hash($passwd); //암호화
	}

	return $hash;
}

//비밀번호 비교
function get_passwd_compare($passwd, $hash_passwd){
	$flag = false;
	//var_dump($flag);

	if(version_compare(PHP_VERSION, '5.3.7') >= 0){

		if(function_exists('password_hash')){	//php 5.5 이상
			
			if(password_verify($passwd, $hash_passwd)){
				$flag = true;
			}

		}
		else{
			include_once $_SERVER['DOCUMENT_ROOT'] . "/common/lib/password.php";
			
			if(password_verify($passwd, $hash_passwd)){
				$flag = true;
			}

		}

	}
	else{
		include_once $_SERVER['DOCUMENT_ROOT'] . "/common/lib/password_hash.php";
		
		if(validate_password($passwd, $hash_passwd)){ 
			$flag = true;
		}

	}

	return $flag;
}

/*******************************/
//주문번호 생성
function get_order_idx(){
	$order_idx = date('Ymd') . "_" . time(); //주문번호
	return $order_idx;
}

//원격지에 파일이 존재하는지 확인
function check_remote_file_exist($filepath){
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $filepath);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$response = curl_exec($ch);

    if($response !== false){
        $file_exist_YN = "Y";
    } 
	else{
        $file_exist_YN = "N";
    }

	curl_close($ch);

	return $file_exist_YN;
}

//이미지 가로, 세로 비율 축소
function get_get_thumbnail_size($max_width, $max_height, $filepath){

	//가로,세로 비율에 맞게 축소
	if(($image_width == $max_width) == ($image_height == $max_height)){	//원본과 가로,세로비율이 같은경우
		$dst_width = $max_width;
		$dst_height = $max_height;
	}
	else if($image_width >= $max_width){	//가로에 기준을 둔경우
		$dst_width = $max_width;
		$dst_height = $max_width * ($image_height / $image_width);
	}
	else if($image_height >= $max_height){	//세로에 기준을 둔경우
		$dst_width = $max_height * ($image_width / $image_height);
		$dst_height = $max_height;
	}
	else{
		$dst_width = $image_width;
		$dst_height = $image_height;
	}

	return array($dst_width, $dst_height);
}
?>
