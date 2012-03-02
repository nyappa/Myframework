<?php
/*
*DB処理に関する共通クラス
*
*/
require_once(dirname(dirname(__FILE__)).'/function.php');
require_once 'DB.php';
require_once DATABASE_CONF;

$model = new Model();
$model->dsn = $dsn;
$model->optons = $options;

class Model {
	
	public $dsn;//DB情報
	public $optons;//DBｵﾌﾟｼｮﾝ
	
	/*
	*DBｴﾗｰ処理用
	*DBｴﾗｰ発生時に処理を中止してエラーを表示
	*本番で表示されないようにしておく
	*/
	private function _error_check($db){
		if (PEAR::isError($db)) {
			die($db->getMessage());
		}
	}
	
	/*
	*DB接続処理
	*
	*/
	private function connect_db(){
		$db =& DB::connect($this->dsn, $this->options);
		$db->query('SET NAMES utf8');
		$this->_error_check($db);
		return $db;
	}
	
	/*
	*データ読み出し用
	*
	*/
	function find($sql,$data = null){
	
		if($data == null){
			$data = array();
		}
		
		$db = $this->connect_db();

		$db->setFetchMode(DB_FETCHMODE_ASSOC);
		$this->_error_check($db);
		
		$res =& $db->query($sql, $data);
		while ($row =& $res->fetchRow()) {
			$rows[] = $row;
		}

		$this->_error_check($db);

		$db->disconnect();
		
		if(isset($rows)){
			return $rows;
		}else{
			return false;
		}
	}
}
?>