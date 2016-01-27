<div id="footer">
	<div class="container">
		<div class="row">
			<!---------------------------------------------------->
			<!-- Latest kb's -->
			<!---------------------------------------------------->
			<div class="col-md-4 col-sm-6">
			<div class="footer-box">
				<h4 class="letter-spacing-1">FAQ</h4>
				<ul class="footer-posts list-unstyled">
					<?php if (isset($kbase) && $kbase != null) : ?>
					<?php $cnt = 1; foreach($kbase as $rec) : ?>
					<?php if ($rec['category']['nickname'] == 'faq'): ?>
						<?php if ($cnt++ > 3) break; ?>
							<li>
								<?php echo $this->html->link($rec['title'], '/kbase/faq/faq'); ?>
								<!-- small>29 June 2015</small -->
							</li>
					<?php endif; ?>
					<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
			</div><!-- col -->

			<!---------------------------------------------------->
			<!-- Links -->
			<!---------------------------------------------------->
			<div id="siteMap" class="col-md-4 col-sm-6">
			<div class="footer-box">
				<h4 class="letter-spacing-1">SITE MAP</h4>
				<ul class="footer-links list-unstyled">
					<li><span class="glyphicon glyphicon-triangle-right"></span><a href="/">Home</a></li>
					<li><span class="glyphicon glyphicon-triangle-right"></span><a href="/users/register">Register</a></li>
					<li><span class="glyphicon glyphicon-triangle-right"></span><a href="/kbase/faq/faq">FAQ</a></li>
					<li><span class="glyphicon glyphicon-triangle-right"></span><a href="/contacts/add">Contact Us</a></li>
					<li><span class="glyphicon glyphicon-triangle-right"></span><a href="/users/login">Login</a></li>
				</ul>
			</div>
			</div><!-- col -->

			<!---------------------------------------------------->
			<!-- Contact Form -->
			<!---------------------------------------------------->
			<div class="col-md-4 col-sm-12">
			<div class="footer-box">

				<h4 class="letter-spacing-1">REQUEST CONSULTATION</h4>
				<p>Enter your email address and we will contact you.</p>
				<form class="validate" action="/contacts/add/" method="post" data-success="Request sent, thank you!" data-toastr-position="bottom-right">
					<div class="input-group">
						<span class="input-group-addon hidden-md hidden-xs"><span class="glyphicon glyphicon-envelope"></span></span>
						<input type="email" id="email" name="email" class="form-control required" placeholder="Your Email">
						<span class="input-group-btn">
							<button class="btn btn-success" type="submit">Send</button>
						</span>
					</div>
				</form>
			</div>
			</div><!-- col -->						
			
		</div><!-- row -->
		
	</div><!-- container -->
	
</div><!-- footer -->
		
<div class="copyright">
	<div class="container center">
		<img style="opacity: .3;" src="/img/logo-footer.png" />
		<div class="marginTop20">&copy; <?= date("Y"); ?> - All Rights Reserved</div>
	</div>
</div>
		
<script src="/js/jquery-2.1.4.min.js"></script>	

<script>

$(document).ready(function() {

$('#phoneButton').click(function() { 
	$('#phoneButton').remove();
	$('.phone').append('<span>+1 405-657-5080</span>');
});
$('#emailButton').click(function() { 
	$('#emailButton').remove();
	$('.email').append('<span>info&#64;devspace&#46;co</span>');
});

});

</script>