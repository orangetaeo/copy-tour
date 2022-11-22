<?php
/*
==================================================
error massage 표시하고 history.back()
호출 방법 : ErrMsg("에러 메세지")
입력 파라메터 : msg(에러메세지문자열)
==================================================
*/
function ErrMsg($msg){
	echo "
	<script type=\"text/javascript\">
	alert('$msg');
	history.back();
	</script>
	";
	exit;
}

/*
==================================================
그 페이지로 이동한다.
호출 방법 : gotourl($url)
입력 파라메터 : $url
==================================================
*/
function gotoURL($url){
	echo "
	<script type=\"text/javascript\">
	location.href = '$url';
	</script>
	";
	exit;
}

/*
==================================================
open창에서 메세지 없이 닫기
호출 방법 : popup_close()
==================================================
*/
function popupClose(){
	echo "
	<script type=\"text/javascript\">
	window.close();
	</script>
	";
	exit;
}

/*
==================================================
open창에서 메세지 보여주고 닫기
호출 방법 : msgClose($msg)
입력 파라메터 : msg(message)
==================================================
*/
function msgClose($msg){
	echo "
	<script type=\"text/javascript\">
	alert('$msg');
	window.close();
	</script>
	";
	exit;
}

/*
==================================================
메세지 처리후 $url로 이동하기
호출 방법 :  msgGoto $msg, $url
입력 파라메터 : msg(message)
==================================================
*/
function msgGoto($msg, $url){
	echo "
	<script type=\"text/javascript\">
	alert('$msg');
	location.href = '$url';
	</script>
	";
	exit;
}

/*
==================================================
메세지 처리후 $url로 이동하기
호출 방법    :  msgGoto $msg, $url
입력 파라메터:	msg(message)
			    $url
==================================================
*/
function msgRGoto($msg, $url){
	echo "
	<script type=\"text/javascript\">
	alert('$msg');
	parent.location.reload();
	location.href = '$url';
	</script>
	";
	exit;
}

/*
==================================================
open창에서 메세지 보여주고 opener창 reflash
호출 방법    :  msgOpenerClose
입력 파라메터:	msg(message)
==================================================
*/
function msgOpenerClose($msg){
	echo "
	<script type=\"text/javascript\">
	alert('$msg');
	opener.location.reload();
	window.close();
	</script>
	";
	exit;
}

/*
==================================================
아이프레임창에서 메세지 보여주고 parent창 $url로 이동하기
호출 방법    :  msgRParentGoto
입력 파라메터:	msg(message)
==================================================
*/
function msgRParentGoto($msg, $url){
	echo "
	<script type=\"text/javascript\">
	alert('$msg');
	parent.location.href = '$url';
	</script>
	";
	exit;
}

/*
==================================================
open창에서 메세지 보여주고 opener창 $url로 이동하기
호출 방법    :  msgROpenerClose
입력 파라메터:	msg(message)
==================================================
*/
function msgROpenerClose($msg, $url){
	echo "
	<script type=\"text/javascript\">
	alert('$msg');
	opener.location.href = '$url';
	window.close();
	</script>
	";
	exit;
}

/*
==================================================
open창에서 메세지 보여주고 parent opener창 reflash
호출 방법    :  msgUpOpener($msg)
입력 파라메터:	msg(message)
==================================================
*/
function msgUpOpener($msg){
	echo "
	<script type=\"text/javascript\">
	alert('$msg');
	parent.opener.location.reload();
	</script>
	";
}

/*
==================================================
다이얼로그 박스에서 메세지 보여주고 닫기
호출 방법    :  DmsgClose($msg)
입력 파라메터:	msg(message)
==================================================
*/
function DmsgClose($msg){
	echo "
	<script type=\"text/javascript\">
	alert('$msg');
	window.returnValue = 'true';
	window.close();
	</script>
	";
	exit;
}

/*
==================================================
다이얼로그 박스에서 메세지 보여주고 에러를 처리할때
호출 방법    :  DmsgClose($msg)
입력 파라메터:	msg(message)
==================================================
*/
function DErrClose($msg){
	echo "
	<script type=\"text/javascript\">
	alert('$msg');
	window.returnValue = 'false';
	window.close();
	</script>
	";
	exit;
}

/*
==================================================
다이얼로그 박스에서 메세지를 보여주기만할때
호출 방법    :  DmsgClose($msg)
입력 파라메터:	OnlyErrmsg(message)
==================================================
*/
function OnlyErrmsg($msg){
	echo "
	<script type=\"text/javascript\">
	alert('$msg');
	</script>
	";
}

function alertError($error_code){

	switch($error_code){
		case "wrong_access" :
			ErrMsg("잘못된 접근방식입니다.");
			break;
		case "fail_upload" :
			ErrMsg("업로드가 안되었습니다.\\n\\n다시 업로드하여 주세요.");
			break;
		case "not_upload" :
			ErrMsg("업로드할 수 없는 파일입니다.");
			break;
		case "not_musicupload" :
			ErrMsg("저작권 문제의 소지가 있는 mp3, wma, asf 형식의 음악파일첨부는 하실 수 없습니다.");
			break;
		case "not_access" :
			ErrMsg("접근 권한이 없습니다.");
			break;
		case "not_exist" :
			ErrMsg("게시판이 존재하지 않습니다.");
			break;
		case "not_login" :
			ErrMsg("회원님만이 게시물을 보실 수 있습니다.\\n\\n로그인을 먼저 하여 주세요.");
			break;
		case "not_admin_word" :
			ErrMsg("운영상 금지어 입니다.");
			break;
		case "not_passwd" :
			ErrMsg("입력하신 비밀번호가 맞지 않습니다.\\n\\n확인하시고 다시 입력하여 주세요.");
			break;
		case "not_id_passwd" :
			ErrMsg("아이디나 비밀번호가 일치하지 않습니다.\\n\\n다시 확인하시고 로그인하여 주세요.");
			break;
		case "not_data" :
			ErrMsg("해당 자료가 존재하지 않습니다.");
			break;
		case "not_file" :
			ErrMsg("해당 파일이나 경로가 존재하지 않습니다.");
			break;
		case "badword" :
			ErrMsg("욕설 및 타인에게 혐오감을 주는 단어는 금지됩니다.");
			break;
		case "only_image" :
			ErrMsg("gif, jpg, jpeg, png, bmp 파일만 업로드하실 수 있습니다.");
			break;
		case "not_open" :
			ErrMsg("임시 폐쇄되었습니다.");
			break;
		case "not_use" :
			ErrMsg("사용중이지 않습니다.");
			break;
		case "not_down" :
			ErrMsg("다운로드 권한이 없습니다.");
			break;
		case "fail_makefolder" :
			ErrMsg("이미 생성되어진 폴더가 있습니다.");
			break;
		case "duplicate_file" :   //동영상, mp3 업로드 중복체크
			ErrMsg("중복된 파일이 있습니다.\\n\\n다른 이름으로 수정 후 업로드 하여 주세요.");
			break;
		case "sql_error" :
			ErrMsg("에러가 발생하였습니다.");
			break;
/*
		case "sql_error" :
			$err_no = mysql_errno();
			$err_msg = mysql_error();
			$error_msg = "error_code " . $err_no . " : " . $err_msg;
			$error_msg = $error_msg;
			ErrMsg($error_msg);
			break;
*/
	}

}
?>
