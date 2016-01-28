<?php $frontPage = (isset($frontPage) && $frontPage); ?>

<nav id="navMain" class="navbar navbar-default">
	<div class="container">
        <div class="navbar-header">
		
					<!-- the logo image --------------------------------------------------------->
					
					<!-- SMALL -->
					<div class="hidden-xl hidden-lg hidden-md navbar-logo-xs">
						<a class="navbar-brand headerHeight" href="/"><img src="/img/logo-main.png" /></a>
					</div>
					
					<!-- ALL OTHER SIZES -->
					<div class="hidden-sm hidden-xs navbar-logo">
						<a class="navbar-brand headerHeight" href="/"><img src="/img/logo-main.png" /></a>
					</div>
				
					<!-- the collapse hamburger --------------------------------------------------------->
					
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
							  
        </div>
		
        <div id="navbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
		  		  
				<li><a class="" href="/">HOME</a></li>	
													
				<?php if ($isLoggedIn) : ?>
					<li class=""><a class="" href="/payments/paypal">PAYMENTS</a></li>
				<?php endif; ?>
								
				<li class=""><a class="" href="/kbase/faq/faq">FAQ</a></li>
				<li class=""><a class="" href="<?php echo $urlContact; ?>">CONTACT</a></li>
				<li class=""><a class="" href="/users/register">REGISTER</a></li>
				
				<li class="dropdown mega-menu"><!-- LOGIN/LOGOUT -->
					<?php if ($isLoggedIn) : ?>
						<a class="" href="/users/logout">LOGOUT&nbsp;(<?php echo $userName; ?>)</a>
					<?php else : ?>
						<a class="" href="/users/login">LOGIN</a>
					<?php endif; ?>
				</li>
				
				<?php if ($isLoggedIn) : ?>
					<li class="dropdown mega-menu"><!-- ADMIN --><a href="/kbase/admin">ADMIN</a></li>
					<li class="dropdown mega-menu"><!-- QNA --><a href="/kbase/qna">QNA</a></li>
				<?php endif; ?>

			</ul>
        </div><!--.nav-collapse -->
	</div><!-- container -->
</nav>
