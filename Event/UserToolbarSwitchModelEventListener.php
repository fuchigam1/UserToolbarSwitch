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
	 * userBeforeFind
	 * ユーザー情報取得の際に、UserToolbarSwitch 情報も併せて取得する
	 * 
	 * @param CakeEvent $event
	 */
	public function userBeforeFind (CakeEvent $event)
	{
		$Model = $event->subject();
		$association = array(
			'UserToolbarSwitch' => array(
				'className' => 'UserToolbarSwitch.UserToolbarSwitch',
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
		if (!isset($Model->data['UserToolbarSwitch']) || empty($Model->data['UserToolbarSwitch'])) {
			return;
		}
		
		$saveData['UserToolbarSwitch'] = $Model->data['UserToolbarSwitch'];
		$saveData['UserToolbarSwitch']['user_id'] = $Model->id;
		if (!$Model->UserToolbarSwitch->save($saveData)) {
			$this->log(sprintf('ID：%s のUserToolbarSwitchの保存に失敗しました。', $Model->data['UserToolbarSwitch']['id']));
		} else {
			$Model->UserToolbarSwitch->saveDblog('ユーザーID: ' . $saveData['UserToolbarSwitch']['user_id'] . ' のツールバー設定を編集しました。');
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
		$data = $Model->UserToolbarSwitch->find('first', array(
			'conditions' => array('UserToolbarSwitch.user_id' => $Model->id),
			'recursive' => -1
		));
		if ($data) {
			if (!$Model->UserToolbarSwitch->delete($data['UserToolbarSwitch']['id'])) {
				$this->log('ID:' . $data['UserToolbarSwitch']['id'] . 'のUserToolbarSwitchの削除に失敗しました。');
			}
		}
	}
	
}
