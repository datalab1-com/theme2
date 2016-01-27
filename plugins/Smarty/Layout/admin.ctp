<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = $site_title;
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
	
	<style>
		/* quick fix for the form input selects dropdown arrow overlapping the text */
		select#project-id, select#task-id
		{
			min-height: 50px;
			font-size: 120%;
		}
		.datetime select
		{
			font-size: 110%;
			min-width: 70px;
		}
		
		table.sessionTable
		{
			width: 600px; 
		}
		
		.sessionTable tr td
		{
			font-size: 150%; 
			border: none;
		}
	</style>

	<?php
		/////////////////////////////////////////////////////
		// JS files
		/////////////////////////////////////////////////////
		echo $this->Html->script('jquery-2.1.4.min');
		// more at the bottom
	?>
	
</head>
<body>

<?php

if (isset($startTimeUtc))
{
	$start = new DateTime($startTimeUtc);
	$stop = new DateTime('now', new DateTimeZone('UTC'));
	$interval = $start->diff($stop);
	$elapsedTime = $interval->format('%H:%I');
	$elapsedLabel = isset($startTimeProject) ? $startTimeProject : 'SESSION';
}

?>

    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name"><h1><a href="/">Home</a></h1></li>
        </ul>
        <section class="top-bar-section">
            <ul class="right">
                <li><a href="/sessions/start">
				
					<?php echo (isset($startTimer) && !$startTimer 
						? '<span style="font-size: 120%; color:red;"><strong>' . $elapsedLabel . ': ' . $elapsedTime . '</strong></span>' 
						: '<span style="font-size: 120%; color: #64FB64;">Start Session</span>'); 
					?></a></li>
					
				<li><a href="/kbase/admin">Kbase</a></li>
				<li><a href="/kbase/group/cms">CMS</a></li>
				<li><a href="/kbase/group/faq">FAQ</a></li>
				<li><a href="/kbase/group/kb">KB</a></li>
				<li><a href="/kbase/group/dev">Dev</a></li>
				<li><a href="/categories">Cats</a></li>
                <li><a href="/contacts/">Contacts</a></li>
                <li><a href="/users/">Users</a></li>
				<li><a href="/pages/store">Store</a></li>
				<!-- li><a href="https://affiliate-program.amazon.com/" target="_blank">Amazon Assoc</a></li -->

				<?php if (!$isLoggedIn) : ?>
					<li><a href="/users/login">Login</a></li>
				<?php else : ?>
					<li><a href="/users/logout">Logout <?php //echo '(' . $userName . ')'; ?></a></li>
				<?php endif; ?>
				
            </ul>
        </section>
    </nav>
	
	
    <?= $this->Flash->render() ?>
	<?= $this->Flash->render('auth') ?>
    <section class="container clearfix">
        <?= $this->fetch('content') ?>
    </section>
	
	
	<div id="wrapper">
		<!-- <FOOTER> -->
		<?php echo $this->element('footer'); ?>
		<!-- </FOOTER> -->
	</div>
</body>
</html>
