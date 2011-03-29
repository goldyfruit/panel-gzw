<?php 
/* SVN FILE: $Id$ */
/* Ftpgroup Test cases generated on: 2009-10-10 11:22:29 : 1255166549*/
App::import('Model', 'Ftpgroup');

class FtpgroupTestCase extends CakeTestCase {
	var $Ftpgroup = null;
	var $fixtures = array('app.ftpgroup', 'app.ftpuser');

	function startTest() {
		$this->Ftpgroup =& ClassRegistry::init('Ftpgroup');
	}

	function testFtpgroupInstance() {
		$this->assertTrue(is_a($this->Ftpgroup, 'Ftpgroup'));
	}

	function testFtpgroupFind() {
		$this->Ftpgroup->recursive = -1;
		$results = $this->Ftpgroup->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Ftpgroup' => array(
			'id'  => 1,
			'ftpuser_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'gid'  => 1,
			'member'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		));
		$this->assertEqual($results, $expected);
	}
}
?>