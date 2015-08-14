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

	function userToolbarSwitchStatusChangeHandler(value){
		if (value) {
			$('#UserToolbarSwitchFrontStatusBox').show('slow');
		} else {
			$('#UserToolbarSwitchFrontStatusBox').hide('fast');
		}
	}
});
</script>

<?php echo $this->BcForm->input('UserToolbarSwitch.id', array('type' => 'hidden')) ?>
<table cellpadding="0" cellspacing="0" class="form-table" id="UserToolbarSwitchTable">
	<tr>
		<th class="col-head">
			<?php echo $this->BcForm->label('UserToolbarSwitch.status', 'ツールバー表示状態') ?>&nbsp;<span class="required">*</span>
		</th>
		<td class="col-input">
			<?php echo $this->BcForm->input('UserToolbarSwitch.status', array('type' => 'checkbox', 'label' => '表示する')) ?>
			<?php echo $this->BcForm->error('UserToolbarSwitch.status') ?>
			
			<div id="UserToolbarSwitchFrontStatusBox" class="display-none">
				<?php echo $this->BcForm->input('UserToolbarSwitch.front_status', array('type' => 'checkbox', 'label' => '公開側でツールバーを表示する')) ?>
				<?php echo $this->BcForm->error('UserToolbarSwitch.front_status') ?>
				<small style="margin-left: 15px;">ログイン中の公開側でのツールバー表示を指定できます。</small>
				<?php echo $this->BcForm->error('UserToolbarSwitch.front_status') ?>
			</div>
		</td>
	</tr>
