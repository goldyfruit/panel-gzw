<?php 
/* SVN FILE: $Id$ */
/* Ftpuser Test cases generated on: 2009-10-10 11:23:26 : 1255166606*/
App::import('Model', 'Ftpuser');

class FtpuserTestCase extends CakeTestCase {
	var $Ftpuser = null;
	var $fixtures = array('app.ftpuser', 'app.user', 'app.ftpgroup');

	function startTest() {
		$this->Ftpuser =& ClassRegistry::init('Ftpuser');
	}

	function testFtpuserInstance() {
		$this->assertTrue(is_a($this->Ftpuser, 'Ftpuser'));
	}

	function testFtpuserFind() {
		$this->Ftpuser->recursive = -1;
		$results = $this->Ftpuser->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Ftpuser' => array(
			'id'  => 1,
			'user_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'password'  => 'Lorem ipsum dolor sit amet',
			'uid'  => 1,
			'gid'  => 1,
			'homedir'  => 'Lorem ipsum dolor sit amet',
			'shell'  => 'Lorem ipsum do',
			'count'  => 1,
			'created'  => '2009-10-10 11:23:25',
			'accessed'  => '2009-10-10 11:23:25',
			'modified'  => '2009-10-10 11:23:25',
			'status'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>