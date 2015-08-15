<?php
/**
 * [ControllerEventListener] UserToolbarSwitch
 *
 * @link			http://www.materializing.net/
 * @author			arata
 * @license			MIT
 */
class UserToolbarSwitchControllerEventListener extends BcControllerEventListener
{
	/**
	 * 登録イベント
	 *
	 * @var array
	 */
	public $events = array(
		'Users.beforeRender',
	);
	
	/**
	 * 処理対象とするアクション
	 * 
	 * @var array
	 */
	private $targetAction = array('admin_edit', 'admin_add');
	
	/**
	 * usersBeforeRender
	 * ユーザー情報追加画面で実行し、UserToolbarSwitch の初期値を設定する
	 * 
	 * @param CakeEvent $event
	 */
	public function usersBeforeRender (CakeEvent $event) {
		if (!BcUtil::isAdminSystem()) {
			return;
		}
		
		$Controller = $event->subject();
		if (!in_array($Controller->request->params['action'], $this->targetAction)) {
			return;
		}
		
		if ($Controller->request->params['action'] == 'admin_add') {
			App::uses('UserToolbarSwitch', 'UserToolbarSwitch.Model');
			$UserToolbarSwitchModel = new UserToolbarSwitch();
			$default = $UserToolbarSwitchModel->getDefaultValue();
			$Controller->request->data['UserToolbarSwitch'] = $default['UserToolbarSwitch'];
			return;
		}
		
		if (isset($Controller->request->data['UserToolbarSwitch']) && empty($Controller->request->data['UserToolbarSwitch'])) {
			App::uses('UserToolbarSwitch', 'UserToolbarSwitch.Model');
			$UserToolbarSwitchModel = new UserToolbarSwitch();
			$default = $UserToolbarSwitchModel->getDefaultValue();
			$Controller->request->data['UserToolbarSwitch'] = $default['UserToolbarSwitch'];
		}
	}
	
}
