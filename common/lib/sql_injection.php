<?php
function stripslashes_deep($var){
    $var = is_array($var) ? array_map('stripslashes_deep', $var) : stripslashes($var);
	return $var;
}
 
function mysql_real_escape_string_deep($var){
    $var = is_array($var) ? array_map('mysql_real_escape_string_deep', $var) : mysqli_real_escape_string(DbMysqliCommon::getInstance(), $var);
    return $var;
}
 
if(get_magic_quotes_gpc()){

    if(is_array($_POST)){
        $_POST = array_map('stripslashes_deep', $_POST);
	}

    if(is_array($_GET)){
        $_GET = array_map('stripslashes_deep', $_GET);
	}

}
 
if(is_array($_COOKIE)){
    $_COOKIE = array_map('mysql_real_escape_string_deep', $_COOKIE);
}

if(is_array($_POST)){
    $_POST = array_map('mysql_real_escape_string_deep', $_POST);
}

if(is_array($_GET)){
    $_GET = array_map('mysql_real_escape_string_deep', $_GET);
}
?>
