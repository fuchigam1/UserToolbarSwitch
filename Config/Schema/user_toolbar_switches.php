<?php 
class UserToolbarSwitchesSchema extends CakeSchema {

	public $file = 'user_toolbar_switches.php';

	public $connection = 'plugin';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $user_toolbar_switches = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'ユーザーID'),
		'status' => array('type' => 'boolean', 'null' => true, 'default' => '1', 'comment' => 'ツールバーの表示状態'),
		'front_status' => array('type' => 'boolean', 'null' => true, 'default' => '1', 'comment' => '公開側のツールバーの表示状態'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '更新日'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '作成日'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

}
