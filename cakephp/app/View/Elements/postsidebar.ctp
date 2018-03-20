<!DOCTYPE HTML>
<html lang="ja-JP">
<div class="container bg-white text-center my-3 pb-3 border-bottom" style="height: 100px;">
	<div class="search-box mx-auto mt-5" style="width:500px;">
			<div>
					<?php
					echo $this->Form->create('Post', ['url' => ['action' => 'search'], 'type' => 'get']);
					?>
					<p class="mb-0 mr-3">ワード検索して記事を探す</p>
					<?php
					echo $this->Form->input('search', ['label' => false,'placeholder'=>'Search...']);
					echo $this->Form->button('search', array('type' => 'submit', 'label'=>false, 'class'=>'btn btn-outline-accent btn-sm'));
					echo $this->Form->end();
					?>
			</div>
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
	<div class="mb-3">Sponsored
	</div>
		<?php
		echo $this->Html->image('/posts/adBanner', array('url'=>'https://www.funteam.co.jp/'));
		?>
</div>
