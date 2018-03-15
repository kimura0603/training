<!DOCTYPE HTML>
<html lang="ja-JP">
<div class="bg-secondary">
		<?php echo $this->Html->link('管理トップへ戻る', array('controller' => 'user', 'action' => 'register'),array('class'=>'text-dark'))?>
			<br>
<div class="text-white">下記管理者ユーザーなら表示</div>
		<?php echo $this->Html->link('追加', array('action' => 'add'),array('class'=>'text-dark'));?>
		<?php echo $this->Html->link('編集', array('action' => 'edit'),array('class'=>'text-dark'));?>
		<?php echo $this->Html->link('削除', array('action' => 'delete'),array('class'=>'text-dark'));?>
		<?php echo $this->Html->link('投稿', array('action' => 'add'),array('class'=>'text-dark'));?>
		</br>
</div>

