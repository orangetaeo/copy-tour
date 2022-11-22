<?
$DB_id = "wnw_demohp" ;
$DB_pw = "w11771177!" ;
$DB_name = "wnw_demohp" ;

// $mysql_con = mysqli_connect('localhost', $DB_id, $DB_pw, $DB_name);
$mysql_con = mysqli_connect('183.111.182.225:3306', $DB_id, $DB_pw, $DB_name);
if(!$mysql_con){
	die('Connexion impossible : ' . mysqli_error());
}

$date_start_default = "2022-01-01" ; // 검색 구간 시작점 초기화
$adm_folder = "manager" ; // 검색 구간 시작점 초기화
$D_code = "D20191126161953" ; // 숙소코드
$image_url = "http://kor7.weneedweb.com" ; // 이미지 경로

//------------------------------ 나이스페이먼츠 MID ----------------------------------------//
$nicepayments_uri = "https://data.nicepay.co.kr/om/api" ;
$nicepayments_MID = "jiair0001m" ;
$nicepayments_KEY = "f6jNLz9cCbDftGEr8+9mji/YnhW8DrL5awJTQ4XeY6a8l3I5TLPzhpUHIqqvB+j1w/omvCdR9HnhnCi/lJIgEA==" ;
$nicepayments_CancelPwd = "123456" ;

//------------------------------ 주소 API info s ----------------------------------------//
$jusoKey = "U01TX0FVVEgyMDE5MTEwNjE2MzY1NzEwOTE3MjU=" ;

//------------------------------ kakao API info s ----------------------------------------//
$aligo_id		= "gair" ; // 알리고 아이디
$aligo_key		= "o4n80fdq2e1ixza2bbedxyvakr04n0wg" ;// 알리고 키
$aligo_senderkey= "d261c04b5a46e879a97f2c765176b1000bec86b7" ; // 알리고 Senderkey
$aligo_sender	= "010-4130-7165" ;

//------------------------------ KCP INFO S ----------------------------------------//
$site_cd	= "B2100" ;
$site_key	= "1p3uAmVU2AvfL7XrcX.AF4L__" ;

$incpath = "/wnw_w6400/www" ; // 반드시 수정으로 조절
$siteurl = "http://" . getenv("HTTP_HOST") . "/";
$SNS_URL = $siteurl . getenv("REQUEST_URI"); // SNS 용 풀 주소
$max_imagesize_width = 1000 ;


$IP				= getenv("REMOTE_ADDR");
$addtional_co	= "위니드투어" ; // 메일 발송용 회사명

include_once $_SERVER['DOCUMENT_ROOT']."/wnw_lib.php3" ;

//---------------------------------------- 이하 인젝션 기본 방지 모듈 ----------------------------------------//
$ext_arr = array('PHP_SELF', '_ENV', '_GET', '_POST', '_FILES', '_SERVER', '_COOKIE', '_SESSION', '_REQUEST', 'HTTP_ENV_VARS', 'HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_POST_FILES', 'HTTP_SERVER_VARS', 'HTTP_COOKIE_VARS', 'HTTP_SESSION_VARS', 'GLOBALS');
$ext_cnt = count($ext_arr);

for($i = 0; $i < $ext_cnt; $i++){

	if(isset($_GET[$ext_arr[$i]])){
		unset($_GET[$ext_arr[$i]]);
	}

}

//php.ini 의 register_globals = off 일 경우
@extract($_GET);
@extract($_POST);
@extract($_SERVER);

include_once $_SERVER['DOCUMENT_ROOT'] . "/common/lib/xss_clean.php";

//-------------------- 모바일 체크 s --------------------//
$device = "pc" ;

global $HTTP_USER_AGENT;
$MobileArray = array("iPhone","iPod","IEMobile","PPC","iphone","lgtelecom","skt","mobile","samsung","nokia","blackberry","android","sony","phone");

$checkCount = 0;
for($i=0; $i<sizeof($MobileArray); $i++){
	if(preg_match("/$MobileArray[$i]/", strtolower($HTTP_USER_AGENT))){ $checkCount++; break; }
}

if ( $checkCount >= 1 ) $device = "mobile" ;
//-------------------- 모바일 체크 e --------------------//

?>
