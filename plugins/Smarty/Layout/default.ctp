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
		
		<?php 
		
			/////////////////////////////////////////////////////
			// CSS files
			/////////////////////////////////////////////////////
			
			echo $this->Html->css('bootstrap.min');
			echo $this->Html->css('essentials');
			echo $this->Html->css('layout');
			
			// not used
			echo $this->Html->css('header-1');
			echo $this->Html->css('color_scheme/green');
			echo $this->Html->css('extralayers');
			echo $this->Html->css('settings');
			
			echo $this->Html->css('custom'); // cake settings partial
			
			/////////////////////////////////////////////////////
			// JS files
			/////////////////////////////////////////////////////
			echo $this->Html->script('jquery-2.1.4.min');
			// more at the bottom
		?>

	</head>

	<body class="smoothscroll enable-animation">
		
		<!-- wrapper -->
		<div id="wrapper">

<!------------------------------------------------------------------------------------------->			
<!----------------------- MAIN MENU --------------------------------------------------------->			
<!------------------------------------------------------------------------------------------->			
		
<?php echo $this->element('main-menu'); ?>

<!------------------------------------------------------------------------------------------->			
<!------------------------------------------------------------------------------------------->			
<!------------------------------------------------------------------------------------------->			
        		
<div style="min-height: 500px;">
	<?= $this->Flash->render() ?>
	<?= $this->Flash->render('auth') ?>
	<section class="container clearfix">
		<?= $this->fetch('content') ?>
	</section>
</div>	

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

		<!-- JAVASCRIPT FILES -->
		<?php echo $this->Html->script('bootstrap.min'); ?>
		
	</body>
</html>