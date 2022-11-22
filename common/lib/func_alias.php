<?php
function sel_tel($val = ""){
	$rtn_val = "";
	$tel = array('02', '031', '032', '033', '041', '042', '043', '051', '052', '053', '054', '055', '061', '062', '063', '064', '070', '080', '0505');

	foreach($tel as $tel_val){ 
		$rtn_val .= "	<option value=\"$tel_val\"";
		if($tel_val == $val) $rtn_val .= " selected=\"selected\"";
		$rtn_val .= ">$tel_val</option>" . PHP_EOL;
	}

	return $rtn_val;
}

function sel_tel2($val = ""){
	$rtn_val = "";
	$tel = array('02', '031', '032', '033', '041', '042', '043', '051', '052', '053', '054', '055', '061', '062', '063', '064', '070');
	$tel2 = array('02 (서울)', '031 (경기)', '032 (인천)', '033 (강원)', '041 (충남)', '042 (대전)', '043 (충북)', '051 (부산)', '052 (울산)', '053 (대구)', '054 (경북)', '055 (경남)', '061 (전남)', '062 (광주)', '063 (전북)', '064 (제주)', '070', '080', '0505');

	foreach($tel as $key => $tel_val){
		$rtn_val .= "	<option value=\"$tel_val\"";
		if($tel_val == $val) $rtn_val .= " selected=\"selected\"";
		$rtn_val .= ">$tel2[$key]</option>" . PHP_EOL;
	}

	return $rtn_val;
}

function sel_hp($val = ""){
	$rtn_val = "";
	$hp = array('010', '011', '016', '017', '018', '019');

	foreach($hp as $hp_val){ 
		$rtn_val .= "	<option value=\"$hp_val\"";
		if($hp_val == $val) $rtn_val .= " selected=\"selected\"";
		$rtn_val .= ">$hp_val</option>" . PHP_EOL;
	}

	return $rtn_val;
}

function sel_tel_hp($val = ""){
	$rtn_val = "";
	$tel = array('02', '031', '032', '033', '041', '042', '043', '051', '052', '053', '054', '055', '061', '062', '063', '064', '070', '080', '0505', '010', '011', '016', '017', '018', '019');

	foreach($tel as $tel_val){ 
		$rtn_val .= "	<option value=\"$tel_val\"";
		if($tel_val == $val) $rtn_val .= " selected=\"selected\"";
		$rtn_val .= ">$tel_val</option>" . PHP_EOL;
	}

	return $rtn_val;
}

function sel_hp_tel($val = ""){
	$rtn_val = "";
	$tel = array('010', '011', '016', '017', '018', '019', '02', '031', '032', '033', '041', '042', '043', '051', '052', '053', '054', '055', '061', '062', '063', '064', '070', '080', '0505');

	foreach($tel as $tel_val){ 
		$rtn_val .= "	<option value=\"$tel_val\"";
		if($tel_val == $val) $rtn_val .= " selected=\"selected\"";
		$rtn_val .= ">$tel_val</option>" . PHP_EOL;
	}

	return $rtn_val;
}

function sel_email($val = ""){
	$rtn_val = "";
	$email = array('daum.net', 'dreamwiz.com', 'gmail.com', 'hanmail.net', 'hotmail.com', 'korea.com', 'msn.com', 'nate.com', 'naver.com', 'yahoo.com');

	$rtn_val .= "	<option value=\"\"";
	if($val == "") $rtn_val .= " selected=\"selected\"";
	$rtn_val .= ">직접입력</option>" . PHP_EOL;

	foreach($email as $email_val){ 
		$rtn_val .= "	<option value=\"$email_val\"";
		if($val == $email_val) $rtn_val .= " selected=\"selected\"";
		$rtn_val .= ">$email_val</option>" . PHP_EOL;
	}

	return $rtn_val;
}

function sel_sido($val = ""){
	$rtn_val = "";
	$sido = array('서울', '경기', "강원", '경남', '경북', '광주', '대구', '대전', '부산', '세종', '울산', '인천', '전남', '전북', '제주', '충남', '충북');

	foreach($sido as $sido_val){ 
		$rtn_val .= "	<option value=\"$sido_val\"";
		if($sido_val == $val) $rtn_val .= " selected=\"selected\"";
		$rtn_val .= ">$sido_val</option>" . PHP_EOL;
	}

	return $rtn_val;
}

function sel_year($syear, $eyear, $val = ""){
	$rtn_val = "";

	for($i = $syear; $i >= $eyear; $i--){    


		if($i == (int)get_sel_cint($val)){
			$rtn_val .= "	<option value=\"$i\" selected=\"selected\">".$i."</option>" . PHP_EOL;
		}
		else{
			$rtn_val .= "	<option value=\"$i\">".$i."</option>" . PHP_EOL;
		}

	}

	return $rtn_val;
}

function sel_year2($syear, $eyear, $val = ""){
	$rtn_val = "";

	for($i = $syear; $i <= $eyear; $i++){    

		if($i == (int)get_sel_cint($val)){
			$rtn_val .= "	<option value=\"$i\" selected=\"selected\">".$i."</option>" . PHP_EOL;
		}
		else{
			$rtn_val .= "	<option value=\"$i\">".$i."</option>" . PHP_EOL;
		}

	}

	return $rtn_val;
}

function sel_month($val = ""){
	$rtn_val = "";

	for($i = 1; $i <= 12; $i++){    
		$j = $i < 10 ? "0" . $i : $i;

		if($i == (int)get_sel_cint($val)){
			$rtn_val .= "	<option value=\"$j\" selected=\"selected\">".$i."</option>" . PHP_EOL;
		}
		else{
			$rtn_val .= "	<option value=\"$j\">".$i."</option>" . PHP_EOL;
		}

	}

	return $rtn_val;
}

function sel_day($val = ""){
	$rtn_val = "";

	for($i = 1; $i <= 31; $i++){    
		$j = $i < 10 ? "0" . $i : $i;

		if($i == (int)get_sel_cint($val)){
			$rtn_val .= "	<option value=\"$j\" selected=\"selected\">".$i."</option>" . PHP_EOL;
		}
		else{
			$rtn_val .= "	<option value=\"$j\">".$i."</option>" . PHP_EOL;
		}

	}

	return $rtn_val;
}

function sel_hour($val = ""){
	$rtn_val = "";

	for($i = 0; $i <= 23; $i++){    
		$j = $i < 10 ? "0" . $i : $i;

		if($i == (int)get_sel_cint($val)){
			$rtn_val .= "	<option value=\"$j\" selected=\"selected\">".$i."</option>" . PHP_EOL;
		}
		else{
			$rtn_val .= "	<option value=\"$j\">".$i."</option>" . PHP_EOL;
		}

	}

	return $rtn_val;
}

function sel_minute($val = ""){
	$rtn_val = "";

	for($i = 0; $i <= 59; $i++){    
		$j = $i < 10 ? "0" . $i : $i;

		if($i == (int)get_sel_cint($val)){
			$rtn_val .= "	<option value=\"$j\" selected=\"selected\">".$i."</option>" . PHP_EOL;
		}
		else{
			$rtn_val .= "	<option value=\"$j\">".$i."</option>" . PHP_EOL;
		}

	}

	return $rtn_val;
}

function sel_minute5($val = ""){
	$rtn_val = "";

	for($i = 0; $i <= 55; $i = $i + 5){    
		$j = $i < 10 ? "0" . $i : $i;

		if($i == (int)get_sel_cint($val)){
			$rtn_val .= "	<option value=\"$j\" selected=\"selected\">".$j."</option>" . PHP_EOL;
		}
		else{
			$rtn_val .= "	<option value=\"$j\">".$j."</option>" . PHP_EOL;
		}

	}

	return $rtn_val;
}

function sel_count($cnt = 10, $val = ""){
	$rtn_val = "";

	for($i = 1; $i <= $cnt; $i++){    

		if($i == (int)get_sel_cint($val)){
			$rtn_val .= "	<option value=\"$i\" selected=\"selected\">".$i."</option>" . PHP_EOL;
		}
		else{
			$rtn_val .= "	<option value=\"$i\">".$i."</option>" . PHP_EOL;
		}

	}

	return $rtn_val;
}

function sel_count2($cnt = 10, $val = ""){
	$rtn_val = "";

	for($i = 0; $i <= $cnt; $i++){    

		if($i == (int)get_sel_cint($val)){
			$rtn_val .= "	<option value=\"$i\" selected=\"selected\">".$i."</option>" . PHP_EOL;
		}
		else{
			$rtn_val .= "	<option value=\"$i\">".$i."</option>" . PHP_EOL;
		}

	}

	return $rtn_val;
}

function sel_increase_count($start_num = 10, $end_num = 100, $increase_num = 10, $val = ""){
	$rtn_val = "";

	for($i = $start_num; $i <= $end_num; $i = $i + $increase_num){    
		$j = $i < 10 ? "0" . $i : $i;

		if($i == (int)get_sel_cint($val)){
			$rtn_val .= "	<option value=\"$j\" selected=\"selected\">".$j."</option>" . PHP_EOL;
		}
		else{
			$rtn_val .= "	<option value=\"$j\">".$j."</option>" . PHP_EOL;
		}

	}

	return $rtn_val;
}

//number_format
function as_number_format($val = 0){
	$rtn_val = "";

	if($val == 0){
		$rtn_val = 0;
	}
	else if($val != ""){
		$rtn_val = number_format($val);
	}

	return $rtn_val;
}

//예/아니오
function as_ox($val = ""){
	$rtn_val = "";
	$val = strtoupper($val);

	if($val == "Y"){
		$rtn_val = "○";
	}
	else{
		$rtn_val = "X";
	}

	return $rtn_val;
}

function as_YN($val = ""){
	$rtn_val = "";
	$val = strtoupper($val);

	if($val == "Y"){
		$rtn_val = "예";
	}
	else{
		$rtn_val = "아니오";
	}

	return $rtn_val;
}

function sel_YN($val = ""){
	$rtn_val = "";
	$YN = array('Y', 'N');
	$YN2 = array('예', '아니오');

	foreach($YN as $key => $YN_val){
		$rtn_val .= "	<option value=\"$YN_val\"";
		if($YN_val == $val) $rtn_val .= " selected=\"selected\"";
		$rtn_val .= ">$YN2[$key]</option>" . PHP_EOL;
	}

	return $rtn_val;
}

function as_open_YN($val = ""){
	$rtn_val = "";
	$val = strtoupper($val);

	if($val == "Y"){
		$rtn_val = "공개";
	}
	else{
		$rtn_val = "비공개";
	}

	return $rtn_val;
}

//공개여부
function sel_open_YN($val = ""){
	$rtn_val = "";
	$YN = array('Y', 'N');
	$YN2 = array('공개', '비공개');

	foreach($YN as $key => $YN_val){
		$rtn_val .= "	<option value=\"$YN_val\"";
		if($YN_val == $val) $rtn_val .= " selected=\"selected\"";
		$rtn_val .= ">$YN2[$key]</option>" . PHP_EOL;
	}

	return $rtn_val;
}

//확인/미확인
function sel_confirm_YN($val = ""){
	$rtn_val = "";
	$YN = array('Y', 'N');
	$YN2 = array('확인', '미확인');

	foreach($YN as $key => $YN_val){
		$rtn_val .= "	<option value=\"$YN_val\"";
		if($YN_val == $val) $rtn_val .= " selected=\"selected\"";
		$rtn_val .= ">$YN2[$key]</option>" . PHP_EOL;
	}

	return $rtn_val;
}

//확인/미확인
function as_confirm($val = ""){
	$rtn_val = "";
	$val = strtoupper($val);

	if($val == "Y"){
		$rtn_val = "확인";
	}
	else{
		$rtn_val = "미확인";
	}

	return $rtn_val;
}

//노출여부
function as_expose_YN($val = ""){
	$rtn_val = "";
	$val = strtoupper($val);

	if($val == "Y"){
		$rtn_val = "노출";
	}
	else{
		$rtn_val = "비노출";
	}

	return $rtn_val;
}

//노출여부
function sel_expose_YN($val = ""){
	$rtn_val = "";
	$YN = array('Y', 'N');
	$YN2 = array('노출', '비노출');

	foreach($YN as $key => $YN_val){
		$rtn_val .= "	<option value=\"$YN_val\"";
		if($YN_val == $val) $rtn_val .= " selected=\"selected\"";
		$rtn_val .= ">$YN2[$key]</option>" . PHP_EOL;
	}

	return $rtn_val;
}

//사용여부
function as_use_YN($val = ""){
	$rtn_val = "";
	$val = strtoupper($val);

	if($val == "Y"){
		$rtn_val = "사용";
	}
	else{
		$rtn_val = "미사용";
	}

	return $rtn_val;
}

//사용여부
function sel_use_YN($val = ""){
	$rtn_val = "";
	$YN = array('Y', 'N');
	$YN2 = array('사용', '미사용');

	foreach($YN as $key => $YN_val){
		$rtn_val .= "	<option value=\"$YN_val\"";
		if($YN_val == $val) $rtn_val .= " selected=\"selected\"";
		$rtn_val .= ">$YN2[$key]</option>" . PHP_EOL;
	}

	return $rtn_val;
}

function sel_delete_YN($val = ""){
	$rtn_val = "";
	$YN = array('Y', 'N');
	$YN2 = array('삭제', '비삭제');

	foreach($YN as $key => $YN_val){
		$rtn_val .= "	<option value=\"$YN_val\"";
		if($YN_val == $val) $rtn_val .= " selected=\"selected\"";
		$rtn_val .= ">$YN2[$key]</option>" . PHP_EOL;
	}

	return $rtn_val;
}

//등록여부
function sel_insert_divi($val = ""){
	$rtn_val = "";
	$insert_divi = array('A', 'U');
	$insert_divi2 = array('관리자', '사용자');

	foreach($insert_divi as $key => $insert_divi_val){
		$rtn_val .= "	<option value=\"$insert_divi_val\"";
		if($insert_divi_val == $val) $rtn_val .= " selected=\"selected\"";
		$rtn_val .= ">$insert_divi2[$key]</option>" . PHP_EOL;
	}

	return $rtn_val;
}

//등록여부
function as_insert_divi($val = ""){
	$rtn_val = "";
	$val = strtoupper($val);

	if($val == "A"){
		$rtn_val = "관리자";
	}
	else{
		$rtn_val = "사용자";
	}

	return $rtn_val;
}

//연결방식
function as_target($val = ""){
	$rtn_val = "";
	$rtn_val = "";

	if($val == "_blank"){
		$rtn_val = "새창";
	}
	else{
		$rtn_val = "현재창";
	}

	return $rtn_val;
}

function sel_target($val = ""){
	$rtn_val = "";
	$target = array('_blank', '_self');
	$target2 = array('새창', '현재창');

	foreach($target as $key => $target_val){
		$rtn_val .= "	<option value=\"$target_val\"";
		if($target_val == $val) $rtn_val .= " selected=\"selected\"";
		$rtn_val .= ">$target2[$key]</option>" . PHP_EOL;
	}

	return $rtn_val;
}

//회원상태
function as_mb_state($val = ""){
	$rtn_val = "";

	switch($val){
		case "0" :
			$rtn_val = "사용중지";
			break;
		case "1" :
			$rtn_val = "사용";
			break;
		case "2" :
			$rtn_val = "탈퇴요청";
			break;
		case "9" :
			$rtn_val = "탈퇴";
			break;
	}

	return $rtn_val;
}

function sel_mb_state($val = ""){
	$rtn_val = "";
	$state = array('0', '1', '2', '9');
	$state2 = array('사용중지', '사용', '탈퇴요청', '탈퇴');

	foreach($state as $key => $state_val){
		$rtn_val .= "	<option value=\"$state_val\"";
		if($state_val == $val) $rtn_val .= " selected=\"selected\"";
		$rtn_val .= ">$state2[$key]</option>" . PHP_EOL;
	}

	return $rtn_val;
}

//남녀 구분
function as_sex($val = ""){
	$rtn_val = "";

	if($val == "M"){
		$rtn_val = "남자";
	}
	else if($val == "F"){
		$rtn_val = "여자";
	}

	return $rtn_val;
}

function sel_sex($val = ""){
	$rtn_val = "";
	$sex = array('M', 'F');
	$sex2 = array('남자', '여자');

	foreach($sex as $key => $sex_val){
		$rtn_val .= "	<option value=\"$sex_val\"";
		if($sex_val == $val) $rtn_val .= " selected=\"selected\"";
		$rtn_val .= ">$sex2[$key]</option>" . PHP_EOL;
	}

	return $rtn_val;
}

//양/음력
function as_sl_cal($val = ""){
	$rtn_val = "";

	if($val == "L"){
		$rtn_val = "(음)";
	}

	return $rtn_val;
}

//성공여부
function sel_success_YN($val = ""){
	$rtn_val = "";
	$success = array('Y', 'N');
	$success2 = array('성공', '실패');

	foreach($success as $key => $success_val){
		$rtn_val .= "	<option value=\"$success_val\"";
		if($success_val == $val) $rtn_val .= " selected=\"selected\"";
		$rtn_val .= ">$success2[$key]</option>" . PHP_EOL;
	}

	return $rtn_val;
}

function as_success_YN($val = ""){
	$rtn_val = "";

	if($val == "Y"){
		$rtn_val = "성공";
	}
	else if($val == "N"){
		$rtn_val = "실패";
	}

	return $rtn_val;
}

/*******************************/
?>
