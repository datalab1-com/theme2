
<div class="row">	
	<div class="col-sm-6 col-sm-offset-3">				
		<?= $this->Form->create(null, ['url' => ['controller' => 'Users', 'action' => 'register'], 'class' => 'form-horizontal']); ?>
		
			<div class="form-group form-control-big">	
			
				<label class="control-label" for="name">Name:</label>
				<?= $this->Form->input('name', ['label' => false, 'class' => 'form-control required formControlSpace20']) ?>

				<label class="control-label" for="name">Email:</label>
				<?= $this->Form->input('email', ['label' => false, 'class' => 'form-control required']) ?>
				<i><div class="formControlSpace20" style="font-size: 90%;">(Email address will be verified)</div></i>

				<label class="control-label" for="name">Password:</label>
				<?= $this->Form->input('password', ['label' => false, 'class' => 'form-control form-control-big required']) ?>
				<i><div class="formControlSpace20" style="font-size: 90%;">(At least 6 upper and lower case letters and numbers)</div></i>
			
			</div>
		
			<?= $this->Form->button(__('Create Account'), ['class' => 'btn btn-primary btn-md']) ?>
		
		<?= $this->Form->end() ?>
	</div>
</div>
