<?php
#purpose : 각종 SQL 관련 디비를 통일성있게  작성할 수 있도록 틀을 제공
interface DbSwitch{
    public function query($sql);           #쿼리
    public function insert($table, $idx);    #저장
    public function update($table, $where);  #수정
    public function delete($table, $where);  #삭제
    public function bindParams($sql, $args = array());   #쿼리 문자 바인드효과
}
?>
<?php
#@ 디비 접속 정보를 미리 설정해 놓겠습니다.
define('_DB_HOST', '127.0.0.1');        #접속 경로
define('_DB_USER', 'orangecommon');                  #접속 아이디
define('_DB_PASSWD', 'Comhome01!nc');        #접속 비밀번호
define('_DB_NAME', 'orangecommon');                  #접속 데이타베이스 명
?>
<?php
#DbMySqli : [클래스 1개] mysqli, [인터페이서 2개] DbSwitch, ArrayAccess 를 상속 받아 구현을 합니다.

#Parent : MySqli
#Parent : DBSwitch
#purpose : mysqli을 활용해 확장한다
class DbMysqliCommon extends mysqli implements DbSwitch, ArrayAccess{
    private $params = array();
	private static $instance = null;
  
	public static function getInstance(){

        if(self::$instance == null){
            self::$instance = new self;
        }

        return self::$instance;
    }

    #dsn : host:dbname = localhost:dbname
    public function __construct($dsn = "", $user = "", $passwd = "", $chrset = "utf8"){
        #데이타베이스 접속
        if(!empty($dsn)){
            $dsn_args = explode(":", $dsn);
            parent::__construct($dsn_args[0], $user, $passwd, $dsn_args[1]);
        }
		else{//config.inc.php --> config.db.php
            parent::__construct(_DB_HOST, _DB_USER, _DB_PASSWD, _DB_NAME);
        }
         
        if(mysqli_connect_error()){
            throw new ErrorException(mysqli_connect_error(), mysqli_connect_errno());
        }
 
        #문자셋
        $chrset_is = parent::character_set_name();
        if(strcmp($chrset_is, $chrset)) parent::set_charset($chrset);
    }
     
    #@ interface : ArrayAccess
    #사용법 : $obj["two"] = "A value";
    public function offsetSet($offset, $value){
        $this->params[$offset] = $value;
    }
     
    #@ interface : ArrayAccess
    #사용법 : isset($obj["two"]); -> bool(true)
    public function offsetExists($offset){
        return isset($this->params[$offset]);
    }
     
    #@ interface : ArrayAccess
    #사용법 : unset($obj["two"]); -> bool(false)
    public function offsetUnset($offset){
        unset($this->params[$offset]);
    }
     
    #@ interface : ArrayAccess
	#사용법 : $obj["two"]; -> string(7) "A value"
    public function offsetGet($offset){
        return isset($this->params[$offset]) ? $this->params[$offset] : null;
    }
     
    #@ interface : DBSwitch
    #:s1 -> :[문자타입]+[변수]
    #:s[문자], :d[정수], :f[소수], :b[바이너리]
    #변수타입, :s1,:sa,:sA, :d1, :d2, :dA 어떻게든 상관없음
    #단 :s1, :s1 이렇게 중복 되어서는 안됨 
    #where 구문만 변경
    //("select * from table where name = ':s1' and age = ':d2'", array('php', 26, '나', 'ㅈㄷ', 22));
    public function bindParams($sql, $args = array()){

        if(strpos($sql, ":") !== false){
            preg_match_all("/(\:[s|d|f|b])+[0-9]+/s", $sql, $matches);

            if(is_array($matches)){

                foreach($matches[0] as $n => $s){
                    #문자타입과 값이 일치하는지 체크
                    $bindtype = substr($s, 1, 1);
                    $bvmatched = false;

                    switch($bindtype){
                        case "s" : if(is_string($args[$n])) $bvmatched = true; break;
                        case "d" : if(is_int($args[$n])) $bvmatched = true; break;
                        case "f" : if(is_float($args[$n])) $bvmatched = true; break;
                        case "b" : if(is_binary($args[$n])) $bvmatched = true; break;
                    }

                    if($bvmatched){
                        $sql = str_replace($s, "%" . $bindtype, $sql);
                        $sql = sprintf("{$sql}", $args[$n]);
                    }
					else{
                        $sql = false;
                        break;
                    }

                }

            }

        }

		return $sql;
    }
 
    #@ return int
	#총게시물 갯수 추출
    public function get_total_record(){

        if($result = parent::query("select FOUND_ROWS()")){
            $row = $result->fetch_row();
			return $row[0];
        }

		return 0;
    }

    #총게시물 갯수 추출
    public function get_total_record2($table, $where = ""){
        $wh = ($where) ? " where " . $where : "";
		$sql = "select count(*) from " . $table . $wh;
		//echo $sql . "<br />";

        if($result = parent::query($sql)){
            $row = $result->fetch_row();
			return $row[0];
        }

		return 0;
    }

    #총게시물 갯수 추출
    public function get_total_record3($table, $where = ""){
		$sql = "select count(*) from " . $table . $where;
		//echo $sql . "<br />";

        if($result = parent::query($sql)){
            $row = $result->fetch_row();
			return $row[0];
        }

		return 0;
    }

	//하나의 레코드 값을 가져오기
    public function get_record($table, $field, $where = ""){
        //$where =($where) ? " where " . $where : "";
		$where = ($where) ? $where : "";
        $sql = "select ". $field . " from " . $table . $where;
		//echo $sql . "<br />";

        if($result = $this->query($sql)){
            $row = $result->fetch_assoc();
            return $row;
        }

		return false;
    }
 
    #@ interface : DBSwitch
    public function query($sql){
		//echo $sql;
        $result = parent::query($sql);

        if(!$result){
            throw new ErrorException(mysqli_error($this) . " " . $sql, mysqli_errno($this));
        }

		return $result;
    }
 
    #@ interface : DBSwitch
    #args = array(key => value)
    #args['name'] = 1, args['age'] = 2;
    public function insert($table, $idx){
        $fieldk = "";
        $datav = "";

        if(count($this->params) < 1){
			return false;
		}

		$data = $this->get_record($table, "ifnull(max(" . $idx . "), 0) + 1 as idx");
		$idx_val = $data['idx'];

		$fieldk = sprintf("%s,", $idx);
		$datav = sprintf("'%s',", $idx_val);

        foreach($this->params as $k => $v){
            $fieldk .= sprintf("%s,", $k);
			$datav .= sprintf("'%s',", $v);
        }

        $fieldk = substr($fieldk, 0, -1);
        $datav = substr($datav, 0, -1);
        $this->params = array(); #변수값 초기화
         
        $sql = sprintf("insert into %s (%s) values (%s)", $table, $fieldk, $datav);
		//echo $sql . "<br />";
        $this->query($sql);

		return $idx_val;
    }

	//자동증가값
    public function insert2($table){
        $fieldk = "";
        $datav = "";

        if(count($this->params) < 1){
			return false;
		}

	    foreach($this->params as $k => $v){
            $fieldk .= sprintf("%s,", $k);
			$datav .= sprintf("'%s',", $v);
        }

        $fieldk = substr($fieldk, 0, -1);
        $datav = substr($datav, 0, -1);
        $this->params = array(); #변수값 초기화
         
        $sql = sprintf("insert into %s (%s) values (%s)", $table, $fieldk, $datav);
		//echo $sql . "<br />";
        $this->query($sql);

		$data = $this->get_record($table, "last_insert_id() as idx");
		$idx_val = $data['idx'];
		return $idx_val;
    }
	
    #@ interface : DBSwitch
	public function update($table, $where){
        $fieldkv = "";
         
        if(count($this->params) < 1){
			return false;
		}

        foreach($this->params as $k => $v){
			$fieldkv .= sprintf("%s='%s',", $k, $v);
        }

        $fieldkv = substr($fieldkv, 0, -1);
        $this->params = array(); #변수값 초기화
         
        $sql = sprintf("update %s set %s where %s", $table, $fieldkv, $where);
		//echo $sql . "<br />";
        $this->query($sql);
    }

    public function exec_sql($sql){   
 		//echo $sql;
        $this->query($sql);
    }

    #@ interface : DBSwitch
    public function delete($table, $where){
        $sql = sprintf("delete from %s where %s", $table, $where);
        $this->query($sql);
    }
     
    #상속한 부모 프라퍼티 값 포함한 가져오기
    public function __get($propertyName){

        if(property_exists(__CLASS__, $propertyName)){
            return $this->{$propertyName};
        }

    }
     
    #db close
    public function __destruct(){
        parent::close();
    }

}
?>
