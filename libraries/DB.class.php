<?php
if (!defined("MyTW")) {
	exit;
}

class DB {

	static $_CONNECT;
	
	static $_SELECTDB;
	
	static $_LAST_ERROR;
	
	static $_LAST_ERRNO;
	
	static $_HOST;
	
	static $_USER;
	
	static $_PASSWORD;
	
	static $_TABLE;

	static function connect($_MYSQL_INFO) {
		list(self::$_HOST,self::$_USER,self::$_PASSWORD,self::$_TABLE) = $_MYSQL_INFO;
		self::$_CONNECT = @mysql_connect(self::$_HOST,self::$_USER,self::$_PASSWORD,'');
		if (!self::$_CONNECT) {
			DB::error();
		} else {
			self::$_SELECTDB = @mysql_select_db(self::$_TABLE,self::$_CONNECT);
			if (!self::$_SELECTDB) {
				$_CREATEDB = DB::Query("CREATE DATABASE `".self::$_TABLE."`",false);
				if (!$_CREATEDB) {
					DB::error();
				} else {
					return self::$_CONNECT;
				}
			} else {
				return self::$_CONNECT;
			}
		}
	}
	
	static function error() {
		self::$_LAST_ERROR = @mysql_error();
		self::$_LAST_ERRNO = @mysql_errno();
		if (self::$_LAST_ERRNO > 1) {
			/*$cl_error->title("Błąd MySQL #".self::$_LAST_ERRNO );
			$cl_error->err("MySQL zwróciło błąd #".self::$_LAST_ERRNO.": <b style='color: red;'>". self::$_LAST_ERROR ."</b>");
			$cl_error->log();
			$cl_error->view();
			$cl_error->clear();*/
			echo "<b>[MySQL]:</b> Błąd ".self::$_LAST_ERRNO.":<br><pre style='color: red;'>". self::$_LAST_ERROR ."</pre>";
			exit;
		}
	}
	
	static function query($_SQL,$_SHOW_ERROR = false,$_CONNECT='') {
		if (empty($_CONNECT)) {
			$_CONNECT = self::$_CONNECT;
		}
		$_QUERY = @MySQL_query($_SQL,$_CONNECT);
		if ($_SHOW_ERROR) {
			if (!$_QUERY) {
				DB::error();
			} else {
				return $_QUERY;
			}
		} else {
			return $_QUERY;
		}
	}
	
	static function fetch($QUERY,$TYPE="array",$_SHOW_ERROR = false) {
		$_FUNC = "MySQL_fetch_$TYPE";
		$_FETCH = @$_FUNC($QUERY);
		if ($_SHOW_ERROR) {
			if (!$_FETCH) {
				DB::error();
			} else {
				return $_FETCH;
			}
		} else {
			return $_FETCH;
		}
	}
	
	static function numrows($QUERY,$_SHOW_ERROR = false) {
		$_NUM = @MySQL_num_rows($QUERY);
		if ($_SHOW_ERROR) {
			if (!$_NUM) {
				DB::error();
			} else {
				return $_NUM;
			}
		} else {
			return $_NUM;
		}	
	}
	
	static function last_err() {
		return ["error"=>self :: $_LAST_ERROR,"errno"=>self :: $_LAST_ERRNO];
	}
}

?>