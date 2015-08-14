<?php
/**
 * [Helper] UserToolbarSwitch
 *
 * @link			http://www.materializing.net/
 * @author			arata
 * @license			MIT
 */
class UserToolbarSwitchHelper extends AppHelper {
/**
 * ヘルパー
 *
 * @var array
 */
	public $helpers = array( 'BcBaser');
	
/**
 * 有効状態を判定する
 * 
 * @param array $data
 * @param string $modelName
 * @return boolean 有効状態
 */
	public function allowPublish($data, $modelName = '') {
		if (!$modelName) {
			$key = key($data);
			$data = $data[$key];
		} else {
			$data = $data[$modelName];
		}
		$allowPublish = (int)$data['status'];
		return $allowPublish;
	}
	
}
