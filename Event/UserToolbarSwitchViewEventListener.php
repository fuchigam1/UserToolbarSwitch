<?php
/**
 * [ViewEventListener] UserToolbarSwitch
 *
 * @link			http://www.materializing.net/
 * @author			arata
 * @license			MIT
 */
class UserToolbarSwitchViewEventListener extends BcViewEventListener
{
	/**
	 * 登録イベント
	 *
	 * @var array
	 */
	public $events = array(
		'beforeLayout',
		'afterElement',
		'afterLayout',
	);

	/**
	 * 処理対象とするエレメント
	 * 
	 * @var array
	 */
	private $targetElement = array('toolbar', 'admin/toolbar');
	
	/**
	 * 管理側のツールバー表示状態
	 * 
	 * @var boolean
	 */
	private $isToolbarAdmin = true;
	
	/**
	 * 公開側のツールバー表示状態
	 * 
	 * @var boolean
	 */
	private $isToolbarFront = true;
	
	/**
	 * アクセス時のプレフィックス
	 * 
	 * @var string
	 */
	private $currentPrefix = '';
	
	/**
	 * beforeLayout
	 * 公開側のツールバー表示を制御する
	 * 
	 * [コアの動作に関わる点]
	 * - 公開側の場合は、BcBaserHelper::scripts タグで表示制御されているためここで制御する
	 *   - /lib/Baser/View/Helper/BcBaserHelper.php::scripts
	 * 
	 * @param CakeEvent $event
	 */
	public function beforeLayout(CakeEvent $event)
	{
		if (BcUtil::isAdminSystem()) {
			return;
		}
		
		$View = $event->subject();
		if (!$this->currentPrefix) {
			$this->checkToolbarStatus($View);
		}
		
		if (!$this->isToolbarAdmin || !$this->isToolbarFront) {
			Configure::write('BcAuthPrefix.'. $this->currentPrefix .'.toolbar', false);
		}
	}
	
	/**
	 * afterElement
	 * 管理側のツールバー表示を制御する
	 * 
	 * [コアの動作に関わる点]
	 * - 管理側では、ツールバーは element で読み込まれているためここで制御する
	 *   - /lib/Baser/View/Elements/admin/header.php
	 * 
	 * @param CakeEvent $event
	 */
	public function afterElement(CakeEvent $event)
	{
		if (!BcUtil::isAdminSystem()) {
			return;
		}
		
		if (!in_array($event->data['name'], $this->targetElement)) {
			return;
		}
		
		$View = $event->subject();
		if (!$this->currentPrefix) {
			$this->checkToolbarStatus($View);
		}
		
		if (!$this->isToolbarAdmin) {
			Configure::write('BcAuthPrefix.'. $this->currentPrefix .'.toolbar', false);
			$event->data['out'] = '';
		}
	}
	
	/**
	 * afterLayout
	 * 管理側のツールバー表示用 css を取り外す
	 * 
	 * [コアの動作に関わる点]
	 * - 管理側では、ツールバー用 css はレイアウトに直書きしてあるため、イベント処理で外すことができない
	 * 　そのため、レイアウト表示迄完了したあとで、該当箇所を消すようにしている
	 * 
	 * @param CakeEvent $event
	 */
	public function afterLayout(CakeEvent $event)
	{
		if (!BcUtil::isAdminSystem()) {
			return;
		}
		
		$View = $event->subject();
		if (!$this->currentPrefix) {
			$this->checkToolbarStatus($View);
		}
		
		if (!$this->isToolbarAdmin) {
			// <link rel="stylesheet" type="text/css" href="/css/admin/toolbar.css" />
			$regex = '/.*toolbar\.css.*/';
			//preg_match($regex, $output, $matches);
			$output = preg_replace($regex, '', $View->output);
			$View->output = $output;
		}
	}
	
	/**
	 * ユーザーのツールバー表示状態を設定する
	 * - ログイン中のユーザー情報から取得する
	 * - 現在の prefix 情報を設定する
	 * 
	 * @param Object $View
	 */
	private function checkToolbarStatus($View)
	{
		if (!isset($View->viewVars['user'])) {
			return;
		}
		if (!isset($View->viewVars['user'][$this->plugin]) || empty($View->viewVars['user'][$this->plugin])) {
			return;
		}
		
		$userToolbarSwitchData = $View->viewVars['user'][$this->plugin];
		if (!$userToolbarSwitchData['status']) {
			$this->isToolbarAdmin = false;
		}
		if (!$userToolbarSwitchData['front_status']) {
			$this->isToolbarFront = false;
		}
		
		$this->currentPrefix = $View->get('currentPrefix');
		//$authPrefix = Configure::read('BcAuthPrefix.' . $$this->currentPrefix);
	}
	
}
