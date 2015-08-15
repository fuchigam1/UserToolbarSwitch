<?php
/**
 * [Model] UserToolbarSwitch
 *
 * @link			http://www.materializing.net/
 * @author			arata
 * @license			MIT
 */
class UserToolbarSwitch extends BcPluginAppModel
{
	/**
	 * ModelName
	 * 
	 * @var string
	 */
	public $name = 'UserToolbarSwitch';
	
	/**
	 * PluginName
	 * 
	 * @var string
	 */
	public $plugin = 'UserToolbarSwitch';
	
	/**
	 * Behavior
	 * 
	 * @var array
	 */
	public $actsAs = array(
		'BcCache',
	);
	
	/**
	 * belongsTo
	 * 
	 * @var array
	 */
	public $belongsTo = array(
		'User' => array(
			'className'	=> 'User',
			'foreignKey' => 'user_id'
		),
	);
	
	/**
	 * 初期値を取得する
	 *
	 * @return array
	 */
	public function getDefaultValue() {
		$data = array(
			$this->name => array(
				'status' => true,
				'front_status' => true,
			)
		);
		return $data;
	}
	
}
