<?php
$_POST['BUTTONPRESSED'] = 'btnCreateUser';
$_POST['fname'] = 'Anthony';
$_POST['lname'] = 'chan';
$_POST['email'] = 'aychan@umass.edu';
$_POST['[password'] = 'mypassword';
require_once(dirname(__DIR__).'/../front_end/back_end/sqlConnection.php'); 
class getConnectionTest extends PHPUnit_Extensions_Database_TestCase {
	// only instantiate pdo once for test clean-up/fixture load
    static protected $pdo = null;
    // only instantiate PHPUnit_Extensions_Database_DB_IDatabaseConnection once per test
    private $conn = null;
	private $currentUsers;
    //protected $dataset = dirname(__DIR__).'seed.xml';
    final public function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$pdo = new \PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_DBNAME']);
        }
        return $this->conn;
    }

	public function testAddEntry()
    {
        
		$queryTable = $this->getConnection()->createQueryTable(
            'USERS', 'SELECT * FROM USERS'
        );
        $expectedTable = $this->createFlatXmlDataSet(dirname(__DIR__)."/testcases/default.xml")
                              ->getTable("USERS");
        $this->assertTablesEqual($expectedTable, $queryTable);
    }
	
     public function getDataSet()
    {
        return $this->createMySQLXMLDataSet(dirname(__DIR__)."/testcases/seed.xml");
    }
	
	public function testgetConnection()
	{
		$queryTable = $this->getConnection()->createQueryTable(
            'USERS', 'SELECT * FROM USERS WHERE email="jkcao@umass.edu"'
        );
		$expectedTable = $this->createFlatXmlDataSet(dirname(__DIR__)."/testcases/default2.xml")
                              ->getTable("USERS");
		$this->assertTablesEqual($expectedTable, $queryTable);
	}
}
