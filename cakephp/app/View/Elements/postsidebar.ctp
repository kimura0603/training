<!DOCTYPE HTML>
<html lang="ja-JP">
<div class="card mt-3">
		<div class="card-body">
				<?php
				echo $this->Form->create('Post', ['url' => ['action' => 'search'], 'type' => 'get', 'class'=>'form-inline']);
				echo $this->Form->input('searchword', ['label' => false,'placeholder'=>'Search...','class'=>'border-0']);
				echo $this->Form->button('Search', array('type' => 'submit', 'label'=>false, 'class'=>'btn btn-outline-secondary btn-sm pull-right'));
				echo $this->Form->end();
				?>
		</div>
</div>
<div class="mt-5">
		<div class="mb-3">
		Profile
		</div>
		<div class="text-center">
			<a>Hoge hoge hoge hoge hoge hoge hoge.Hoge hoge hoge hoge hoge hoge hoge.Hoge hoge hoge hoge hoge hoge hoge.</a>
		</div>
</div>
<div class="mt-5">
		<div class="mb-3">Popular posts
		</div>
		<div class="text-left pl-5">
		<?php
		$i = 1;
		foreach ($topPosts as $values):
		?>
				<div>
				<?php
				echo $i.".";
				echo $this->Html->link($values['Post']['title'],
				array('controller' => 'posts', 'action' => 'view', $values['Post']['id']));
				?>
				</div>
		<?php
		$i += 1;
		endforeach;
		unset($values);
		?>
		</div>
</div>
<div class="mt-5">
		<?php
		echo $this->Html->image('/posts/adBanner', array('url'=>'https://www.funteam.co.jp/'));
		?>
</div>
