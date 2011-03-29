<?php 
/* SVN FILE: $Id$ */
/* Ftpgroup Fixture generated on: 2009-10-10 11:22:28 : 1255166548*/

class FtpgroupFixture extends CakeTestFixture {
	var $name = 'Ftpgroup';
	var $table = 'ftpgroups';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'ftpuser_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'gid' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'member' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'groupname' => array('column' => 'name', 'unique' => 0))
	);
	var $records = array(array(
		'id'  => 1,
		'ftpuser_id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'gid'  => 1,
		'member'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
	));
}
?>