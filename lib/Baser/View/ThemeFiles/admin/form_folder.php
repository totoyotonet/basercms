<?php
/**
 * baserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright (c) baserCMS Users Community <http://basercms.net/community/>
 *
 * @copyright		Copyright (c) baserCMS Users Community
 * @link			http://basercms.net baserCMS Project
 * @package			Baser.View
 * @since			baserCMS v 0.1.0
 * @license			http://basercms.net/license/index.html
 */

/**
 * [ADMIN] テーマフォルダ登録・編集
 *
 * @var BcAppView $this
 */
$params = explode('/', $path);
$this->BcBaser->js('admin/theme_files/form_folder');
?>


<div class="em-box align-left">
	現在の位置：<?php echo $currentPath ?>
</div>

<?php if ($this->request->action == 'admin_add_folder'): ?>
	<?php echo $this->BcForm->create('ThemeFolder', ['id' => 'TemplateForm', 'url' => array_merge(['controller' => 'theme_files', 'action' => 'add_folder', $theme, $type], $params)]) ?>
<?php else: ?>
	<?php echo $this->BcForm->create('ThemeFolder', ['id' => 'TemplateForm', 'url' => array_merge(['controller' => 'theme_files', 'action' => 'edit_folder', $theme, $type], $params)]) ?>
<?php endif ?>

<?php echo $this->BcFormTable->dispatchBefore() ?>

<?php if($theme	!= 'core' && !$isWritable): ?>
	<div id="AlertMessage">ファイルに書き込み権限がないので編集できません。</div>
<?php endif ?>

<?php echo $this->BcForm->input('ThemeFolder.parent', ['type' => 'hidden']) ?>
<?php echo $this->BcForm->input('ThemeFolder.pastname', ['type' => 'hidden']) ?>

<!-- form -->
<div class="section">
	<table cellpadding="0" cellspacing="0" id="FormTable" class="form-table">
		<tr>
			<th class="col-head"><?php echo $this->BcForm->label('ThemeFolder.name', 'フォルダ名') ?>&nbsp;<span class="required">*</span></th>
			<td class="col-input">
				<?php if ($this->request->action != 'admin_view_folder'): ?>
					<?php echo $this->BcForm->input('ThemeFolder.name', ['type' => 'text', 'size' => 40, 'maxlength' => 255, 'autofocus' => true]) ?>
					<?php echo $this->Html->image('admin/icn_help.png', ['id' => 'helpName', 'class' => 'btn help', 'alt' => 'ヘルプ']) ?>
					<div id="helptextName" class="helptext">
						<ul>
							<li>フォルダ名は半角で入力してください。</li>
						</ul>
					</div>
					<?php echo $this->BcForm->error('ThemeFolder.name') ?>
				<?php else: ?>
					<?php echo $this->BcForm->input('ThemeFolder.name', ['type' => 'text', 'size' => 40, 'readonly' => 'readonly']) ?>
				<?php endif ?>
			</td>
		</tr>
		<?php echo $this->BcForm->dispatchAfterForm() ?>
	</table>
</div>

<?php echo $this->BcFormTable->dispatchAfter() ?>

<div class="submit">
	<?php if ($this->request->action == 'admin_add_folder'): ?>
		<?php $this->BcBaser->link('一覧に戻る', array_merge(['action' => 'index', $theme, $plugin, $type], explode('/', $path)), ['class' => 'btn-gray button']); ?>
		<?php echo $this->BcForm->submit('保存', ['div' => false, 'class' => 'button', 'id' => 'BtnSave']) ?>
	<?php elseif ($this->request->action == 'admin_edit_folder'): ?>
		<?php $this->BcBaser->link('一覧に戻る', array_merge(['action' => 'index', $theme, $plugin, $type], explode('/', $path)), ['class' => 'btn-gray button']); ?>
		<?php if($isWritable): ?>
			<?php echo $this->BcForm->submit('保存', ['div' => false, 'class' => 'button', 'id' => 'BtnSave']) ?>
			<?php $this->BcBaser->link('削除', array_merge(['action' => 'del', $theme, $type], $params), ['class' => 'submit-token button'], sprintf('%s を本当に削除してもいいですか？', $this->BcForm->value('ThemeFolder.name')), false	) ?>
		<?php endif ?>	
	<?php else: ?>
		<?php $this->BcBaser->link('一覧に戻る', array_merge(['action' => 'index', $theme, $plugin, $type], explode('/', dirname($path))), ['class' => 'btn-gray button']); ?>
		<?php if (!$safeModeOn): ?>
			<?php if ($theme == 'core'): ?>
				<?php $this->BcBaser->link('現在のテーマにコピー', array_merge(['action' => 'copy_folder_to_theme', $theme, $plugin, $type], $params), ['class' => 'submit-token btn-red button'], '本当に現在のテーマ「' . Inflector::camelize($siteConfig['theme']) . "」にコピーしてもいいですか？\n既に存在するファイルは上書きされます。"); ?>
			<?php endif ?>
		<?php else: ?>
			機能制限のセーフモードで動作していますので、現在のテーマへのコピーはできません。
		<?php endif ?>
	<?php endif ?>
</div>

<?php echo $this->BcForm->end() ?>
