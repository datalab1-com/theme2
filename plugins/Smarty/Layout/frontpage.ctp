<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
	<head>
		<meta charset="utf-8" />
		<title><?php echo $site_title; ?></title>
		<meta name="keywords" content="HTML5,CSS3,PHP,MySQL" />
		<meta name="description" content="" />
		<meta name="Author" content="<?php echo $site_author; ?>" />

		<!-- mobile settings -->
		<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->

		<!-- WEB FONTS : use %7C instead of | (pipe) -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400%7CRaleway:300,400,500,600,700%7CLato:300,400,400italic,600,700" rel="stylesheet" type="text/css" />
		
		<!-- CORE CSS -->
		<!--
		<link href="/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="/css/essentials.css" rel="stylesheet" type="text/css" />
		<link href="/css/layout.css" rel="stylesheet" type="text/css" />
		<link href="/css/header-1.css" rel="stylesheet" type="text/css" />
		<link href="/css/color_scheme/green.css" rel="stylesheet" type="text/css" id="color_scheme" />
		<link href="/plugins/slider.revolution/css/extralayers.css" rel="stylesheet" type="text/css" />
		<link href="/plugins/slider.revolution/css/settings.css" rel="stylesheet" type="text/css" />
		-->
		
		<?php 
			echo $this->Html->css('bootstrap.min');
			echo $this->Html->css('essentials');
			echo $this->Html->css('layout');
			echo $this->Html->css('header-1');
			echo $this->Html->css('color_scheme/green');
			echo $this->Html->css('extralayers');
			echo $this->Html->css('settings');
			echo $this->Html->css('custom');
		?>
		
		<style>
		
		.tech {
			float: left;
			margin: 10px;
		}
		
		.logos {
			width: 200px;
			text-align: center;
			float: left;
			margin: 10px;
		}
		
		.logos img {
			height: 100px;
		}
		
		</style>
	</head>

	<!--
		AVAILABLE BODY CLASSES:
		
		smoothscroll 			= create a browser smooth scroll
		enable-animation		= enable WOW animations

		bg-grey					= grey background
		grain-grey				= grey grain background
		grain-blue				= blue grain background
		grain-green				= green grain background
		grain-blue				= blue grain background
		grain-orange			= orange grain background
		grain-yellow			= yellow grain background
		
		boxed 					= boxed layout
		pattern1 ... patern11	= pattern background
		menu-vertical-hide		= hidden, open on click
		
		BACKGROUND IMAGE [together with .boxed class]
		data-background="/img/boxed_background/1.jpg"
	-->
	<body class="smoothscroll enable-animation">
		
		<!-- wrapper -->
		<div id="wrapper">

<?php echo $this->element('main-menu', ['frontPage' => true]); ?>
		
<!------------------------------------------------------------------------------------------->			
<!------------------------------------------------------------------------------------------->			
<!------------------------------------------------------------------------------------------->			
        
<?= $this->Flash->render() ?>
<?= $this->Flash->render('auth') ?>
<?= $this->fetch('content') ?>
		
<!------------------------------------------------------------------------------------------->			
<!------------------------------------------------------------------------------------------->			
<!------------------------------------------------------------------------------------------->			
						
			<!-- CALLOUT -->
			<!--
			<div class="alert alert-transparent bordered-bottom nomargin">
				<div class="container">

					<div class="row">

						<div class="col-md-9 col-sm-12">
							<h3>Call now at <span><strong>+800-565-2390</strong></span> and get 15% discount!</h3>
							<p class="font-lato weight-300 size-20 nomargin-bottom">
								We truly care about our users and our product.
							</p>
						</div>

						
						<div class="col-md-3 col-sm-12 text-right">
							<a href="/pages/contact" class="btn btn-primary btn-lg">CONTACT US</a>
						</div>

					</div>

				</div>
			</div>
			<!-- /CALLOUT >
			-->

			<!-- <FOOTER> -->
				<?php echo $this->element('footer'); ?>
			<!-- </FOOTER> -->

		</div>
		<!-- /wrapper -->


		<!-- SCROLL TO TOP -->
		<a href="#" id="toTop"></a>


		<!-- PRELOADER -->
		<div id="preloader">
			<div class="inner">
				<span class="loader"></span>
			</div>
		</div><!-- /PRELOADER -->


		<!-- JAVASCRIPT FILES -->
		<script type="text/javascript">var plugin_path = '/plugins/';</script>
		
		<!-- original		
		<script type="text/javascript" src="/plugins/jquery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="/js/scripts.js"></script>
		<script type="text/javascript" src="/plugins/slider.revolution/js/jquery.themepunch.tools.min.js"></script>
		<script type="text/javascript" src="/plugins/slider.revolution/js/jquery.themepunch.revolution.min.js"></script>
		<script type="text/javascript" src="/js/view/demo.revolution_slider.js"></script>
		original -->

		<?php
			echo $this->Html->script('jquery-2.1.4.min');
			echo $this->Html->script('bootstrap.min');
			echo $this->Html->script('scripts-clear');
			echo $this->Html->script('jquery.themepunch.tools.min');
			echo $this->Html->script('jquery.themepunch.revolution.min');
			echo $this->Html->script('demo.revolution_slider');
			//not needed: echo $this->Html->script('styleswitcher');
		?>
		<script>
			
			if (typeof scriptsjs == 'undefined')
				alert("scriptsjs not loaded");
				
			if (typeof themepunch_tools_min_js == 'undefined')
				alert("themepunch_tools_min_js not loaded");

			if (typeof themepunch_revolution_min_js == 'undefined')
				alert("themepunch_revolution_min_js not loaded");

			if (typeof demo_revolution_slider == 'undefined')
				alert("demo_revolution_slider not loaded");
				
			//alert('scripts loaded');
				
		</script>

	</body>
</html>