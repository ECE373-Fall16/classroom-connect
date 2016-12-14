<?php

class testConnection extends getConnectionTest
{
    public function testgetConnection()
	{
		$this->assertEquals(2, $this->getConnection()->getRowCount('classes'));
	}
}