<?php
header("content-type:text/html; charset=utf-8");
header("cache-control: private"); 
//ob_start();

include_once $_SERVER['DOCUMENT_ROOT'] . "/common/lib/function.php";

$origin_filename = iconv_to_euckr($_GET['origin_filename']);
$filename = $_GET['filename'];
$real_filepath = $_SERVER['DOCUMENT_ROOT'] . "/images777/" . $filename;

if(!is_file($real_filepath)){ 
	echo "
	<script language='javascript'>
	alert(\"해당 파일이나 경로가 존재하지 않습니다.\");
	history.back();
	</script>
	";
	exit;
} 

if ( preg_match("/MSIE /", $_SERVER['HTTP_USER_AGENT'])){
	header("Content-Type: doesn/matter");	//다운로드 받을 땐 무엇을 적어도 상관 없음
	header("Content-Length: ".(string)(filesize("$real_filepath"))); 
	header("Content-Disposition: attachment; filename=$origin_filename"); 
	header("Content-Transfer-Encoding: binary");
	header("Pragma: no-cache");
	header("Expires: 0");
	header("Cache-Control: cache, must-revalidate");
} else { 
	Header("Content-type: file/unknown");     
	Header("Content-Length: ".(string)(filesize("$real_filepath"))); 
	Header("Content-Disposition: attachment; filename=$origin_filename"); 
	Header("Content-Description: PHP4 Generated Data"); 
	Header("Pragma: no-cache"); 
	Header("Expires: 0"); 
} 

$fp = fopen("$real_filepath", "rb"); 

if(!fpassthru($fp)){ 
	fclose($fp); 
}

exit;
?>
