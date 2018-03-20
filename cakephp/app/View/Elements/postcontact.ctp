<!DOCTYPE HTML>
<html lang="ja-JP">
<div class="container contact" id="contact">
		<div class="cover-contact text-center text-dark pt-5 my-3">
				<h2 class="display-4 mb-4">Contact Us</h2>
		</div>
		<div class="text-center">
				<?php
				// echo $this->Form->create('PostContact', ['url' => ['controller' => 'posts', 'action' => 'contact'], 'type' => 'post']);
				echo $this->Form->create('PostContact', ['url' => ['controller'=> 'posts', 'action' => 'index'], 'type' => 'post']);
				?>
				<!-- <div class="contact-form row form-group my-1"> -->
				<div class="form-row form-group my-1">
						<label class="col-md-4 col-form-label col-form-label-lg">Name</label>
						<div class="col-md-8">
							<?php
											echo $this->Form->Input('name', array('type' => 'text', 'label'=>false, 'class'=>'form-control form-control-sm', 'placeholder'=>'Name','required'=>false));
							?>
						</div>
				</div>
				<div class="form-row form-group my-1">
						<label class="col-md-4 col-form-label col-form-label-lg">Department</label>
						<div class="col-md-8">
							<?php
							echo $this->Form->Input('department', array('type' => 'text', 'label'=>false, 'class'=>'form-control form-control-sm','placeholder'=>'Department','required'=>false));
							?>
						</div>
				</div>
				<div class="form-row form-group my-1">
						<label class="col-md-4 col-form-label col-form-label-lg">Copmany</label>
						<div class="col-md-8">
							<?php
							echo $this->Form->Input('company', array('type' => 'text', 'label'=>false, 'class'=>'form-control form-control-sm','placeholder'=>'Company','required'=>false));
							?>
						</div>
				</div>
				<div class="contact-form row form-group my-1">
						<label class="col-md-4 col-form-label col-form-label-lg">Email</label>
						<div class="col-md-8">
							<?php
							echo $this->Form->Input('email', array('type' => 'text', 'label'=>false, 'class'=>'form-control form-control-sm','placeholder'=>'you@example.com','required'=>false));
							?>
						</div>
				</div>
				<div class="contact-form row form-group my-1">
						<label class="col-md-4 col-form-label col-form-label-lg">Message</label>
						<div class="col-md-8">
							<?php
							echo $this->Form->Input('message', array('type' => 'text', 'label'=>false, 'maxlength'=>200, 'rows'=>10,'class'=>'form-control form-control-sm','placeholder'=>'Message','required'=>false));
							?>
						</div>
				</div>
				<div class="contact-button w-75 my-3 text-center">
						<?php
						echo $this->Form->button('Submit Message', array('type' => 'submit', 'label'=>false, 'class'=>'btn btn-accent-color btn-lg btn-block badge-pill', 'name'=>'contact'));
						// echo $this->Form->submit('Submit Message', array('type' => 'submit', 'label'=>false, 'class'=>'btn btn-dark btn-lg btn-block badge-pill', 'name'=>'contact'));
						echo $this->Form->end();
						?>
				</div>
				<div class="alert alert-<?php if(isset($msg)){if($msg['result'] == 0){echo 'success';}else{echo 'danger';}}?>" role="alert">
				<?php if(isset($msg['msg'])){foreach($msg['msg'] as $key){ echo $key;?>
				<br>
				<?php }}?>
				</div>
		</div>
</div>