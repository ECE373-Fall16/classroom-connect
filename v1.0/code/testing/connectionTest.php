<?php
//require_once 'PHPUnit/Extensions/Database/TestCase.php';

class getConnectionTest extends PHPUnit_Extensions_Database_TestCase {
	public function getConnenection()
	{
		protected $pdo;
		public function __construct(){
			$this->pdo = PHPUnit_Util_PDO::factory(
			'mysql:://root@localhost/CLASSROOMCONNECT');
			BankAccount::createTable($this->pdo);
		}
		
		protected function getConnection(){
			return $this->createDefaultDBConnection($this-.pdo, 'mysql');
		}
		protected function getDataSet(){
			return $this->createFlatXMLDataSet('/home/josephkcao/testing/classroom-connect/testing/seed.xml');
		}
		
	}
}