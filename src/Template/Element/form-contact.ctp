		
<div class="row">	
	<div class="col-sm-6 col-sm-offset-3">				
		<form class="form-horizontal validate" action="/contacts/add/fp" method="post" data-success="Request sent, thank you!" data-toastr-position="bottom-right">
		
			<div class="form-group form-control-big">	
			
				<label class="control-label" for="name">Name:</label>
				<input type="text" id="name" name="name" class="form-control formControlSpace required" placeholder="Your name">

				<label class="control-label" for="email">Email:</label>
				<input type="text" id="email" name="email" class="form-control formControlSpace required" placeholder="Your email address">

				<label class="control-label" for="message">Message:</label>
				<textarea rows="5" id="message" name="message" class="form-control formControlSpace required" placeholder="Please enter a message"></textarea>
				
			</div>
			
			<div class="text-center">			
				<?= $this->Form->button(__('Send Message'), ['class' => 'btn btn-primary btn-md']) ?>
			</div>

		<?= $this->Form->end() ?>
	</div>
</div>
