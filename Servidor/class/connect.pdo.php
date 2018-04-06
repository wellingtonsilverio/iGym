<?php

// FOR DOWNLOAD FILE WHEN MADE EXTERNAL ACCESS 
//header("Access-Control-Allow-Origin:*");
//header("Content-Type: application/x-www-form-urlencoded");
//header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// CLASS FOR CONECTIONS IN THE SAME DATABASE
class Connect{

	public static $instance;

	public function Connect() {
		return $this->getInstance();
	}

	public static function getInstance() {
		$host = "localhost";
		$dbName = "igym";
		$usrNick = "root";
		$usrPass = "";

		if (!isset(self::$instance)) {
			self::$instance = new PDO('mysql:host='.$host.';dbname='.$dbName, $usrNick, $usrPass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
		}

		return self::$instance;
	}
}
?>