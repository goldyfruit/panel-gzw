<?php 
/* SVN FILE: $Id$ */
/* Log Fixture generated on: 2010-04-08 14:52:41 : 1270731161*/

class LogFixture extends CakeTestFixture {
	var $name = 'Log';
	var $table = 'logs';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'action' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'date' => array('type'=>'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'type' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'ip' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 15),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id' => 1,
		'user_id' => 1,
		'action' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'date' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'type' => 'Lorem ipsum dolor sit amet',
		'ip' => 'Lorem ipsum d'
	));
}
?>