<?php
/**
 * [ModelEventListener] UserToolbarSwitch
 *
 * @link			http://www.materializing.net/
 * @author			arata
 * @license			MIT
 */
class UserToolbarSwitchModelEventListener extends BcModelEventListener
{
	/**
	 * 登録イベント
	 *
	 * @var array
	 */
	public $events = array(
		'User.beforeFind',
		'User.afterSave',
		'User.afterDelete',
	);
	
	/**
	 * プラグインのモデル名
	 * 
	 * @var string
	 */
	private $pluginModelName = 'UserToolbarSwitch';
	
	/**
	 * userBeforeFind
	 * ユーザー情報取得の際に、UserToolbarSwitch 情報も併せて取得する
	 * 
	 * @param CakeEvent $event
	 */
	public function userBeforeFind (CakeEvent $event)
	{
		$Model = $event->subject();
		$association = array(
			$this->pluginModelName => array(
				'className' => $this->plugin .'.'. $this->pluginModelName,
				'foreignKey' => 'user_id'
			)
		);
		$Model->bindModel(array('hasOne' => $association));
	}
	
	/**
	 * userAfterSave
	 * ユーザー情報保存時に、UserToolbarSwitch 情報を保存する
	 * 
	 * @param CakeEvent $event
	 */
	public function userAfterSave (CakeEvent $event)
	{
		$Model = $event->subject();
		if (!isset($Model->data[$this->pluginModelName]) || empty($Model->data[$this->pluginModelName])) {
			return;
		}
		
		$saveData[$this->pluginModelName] = $Model->data[$this->pluginModelName];
		$saveData[$this->pluginModelName]['user_id'] = $Model->id;
		if (!$Model->{$this->pluginModelName}->save($saveData)) {
			$this->log(sprintf('ID：%s の'. $this->pluginModelName .'の保存に失敗しました。', $Model->data[$this->pluginModelName]['id']));
		} else {
			clearAllCache();
		}
	}
	
	/**
	 * userAfterDelete
	 * ユーザー情報削除時、そのユーザーが持つ UserToolbarSwitch 情報を削除する
	 * 
	 * @param CakeEvent $event
	 */
	public function userAfterDelete (CakeEvent $event)
	{
		$Model = $event->subject();
		$data = $Model->{$this->pluginModelName}->find('first', array(
			'conditions' => array($this->pluginModelName .'.user_id' => $Model->id),
			'recursive' => -1
		));
		if ($data) {
			if (!$Model->{$this->pluginModelName}->delete($data[$this->pluginModelName]['id'])) {
				$this->log('ID:' . $data[$this->pluginModelName]['id'] . 'の'. $this->pluginModelName .'の削除に失敗しました。');
			}
		}
	}
	
}
