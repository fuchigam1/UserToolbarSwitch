<?php
/**
 * [ADMIN] UserToolbarSwitch
 *
 * @link			http://www.materializing.net/
 * @author			arata
 * @license			MIT
 */
?>
</table>

<script>
/**
 * UserToolbarSwitch用のJS処理
 */
$(function(){
	userToolbarSwitchStatusChangeHandler($("#UserToolbarSwitchStatus").prop('checked'));

	$('#UserToolbarSwitchStatus').change(function() {
		userToolbarSwitchStatusChangeHandler($(this).prop('checked'));
	});

	/**
	 * ツールバーを「表示する」にチェックした動作
	 * - チェックを入れると「公開側でツールバーを表示する」を表示する
	 * - チェックを外すと「公開側でツールバーを表示する」を非表示にする
	 *   - 「公開側でツールバーを表示する」のチェックを外す
	 *   - 「公開側でツールバーを表示する」にチェックが入っている場合はアラートを表示する
	 * 
	 * @param {boolean} value
	 */
	function userToolbarSwitchStatusChangeHandler(value){
		if (value) {
			$('#UserToolbarSwitchFrontStatusBox').show('slow');
		} else {
			frontStatus = $('#UserToolbarSwitchFrontStatus').prop('checked');
			if (frontStatus) {
				if (confirm('公開側でのツールバーも非表示にします。\nよろしいですか？')) {
					$('#UserToolbarSwitchFrontStatus').prop('checked', false);
					$('#UserToolbarSwitchFrontStatusBox').hide('fast');
				} else {
					$("#UserToolbarSwitchStatus").prop('checked', true);
				}
				return false;
			}
			$('#UserToolbarSwitchFrontStatusBox').hide('fast');
		}
	}
});
</script>

<?php echo $this->BcForm->input('UserToolbarSwitch.id', array('type' => 'hidden')) ?>
<table cellpadding="0" cellspacing="0" class="form-table" id="UserToolbarSwitchTable">
	<tr>
		<th class="col-head">
			<?php echo $this->BcForm->label('UserToolbarSwitch.status', 'ツールバー表示状態') ?>
		</th>
		<td class="col-input">
			<?php echo $this->BcForm->input('UserToolbarSwitch.status', array('type' => 'checkbox', 'label' => '表示する')) ?>
			<?php echo $this->BcForm->error('UserToolbarSwitch.status') ?>
			
			<div id="UserToolbarSwitchFrontStatusBox" class="display-none">
				<?php echo $this->BcForm->input('UserToolbarSwitch.front_status', array('type' => 'checkbox', 'label' => '公開側でツールバーを表示する')) ?>
				<?php echo $this->BcForm->error('UserToolbarSwitch.front_status') ?>
				<small style="margin-left: 15px;">[公開側でログイン中に表示されるツールバー表示状態を指定できます]</small>
				<?php echo $this->BcForm->error('UserToolbarSwitch.front_status') ?>
			</div>
		</td>
	</tr>
