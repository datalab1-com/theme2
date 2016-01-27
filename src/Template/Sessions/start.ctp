<!------------------------------------------------------------------------------------------------->
<!-- LEFT MENU -->
<!------------------------------------------------------------------------------------------------->

<?php
	$timezone = "America/Chicago";
	
	if (isset($session->created))
	{
		$startTime = $session->created;
		$startTime->timezone = $timezone;
	}
	else
	{
		$startTime = null;
	}
?>

<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Project'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tasks'), ['controller' => 'Tasks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Task'), ['controller' => 'Tasks', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sessions'), ['controller' => 'Sessions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Session'), ['controller' => 'Sessions', 'action' => 'add']) ?></li>
    </ul>
</nav>

<!------------------------------------------------------------------------------------------------->
<!-- QUICK ADD -->
<!------------------------------------------------------------------------------------------------->

<div class="sessions index large-9 medium-8 columns content">
<?php if (isset($startSession) && $startSession) : ?>

	<!----------------------------------------->
	<!-- START SESSION FORM -->
	<!----------------------------------------->

    <!-- h3><?= __('Session') ?></h3 -->	
    <?= $this->Form->create($session, array('url' => array('controller' => 'sessions', 'action' => 'add'))) ?>
    <fieldset>
        <legend><?= __('Start Session') ?></legend>
        <?php
            echo $this->Form->input('project_id', ['options' => $projectsSession, 'default' => $lastProject]);
            echo $this->Form->input('task_id', ['options' => $tasks, 'default' => $lastTask]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('START NEW SESSION'), ['style' => 'font-weight: bold; font-size: 150%; background: #41E341;']) ?>
    <?= $this->Form->end() ?>	
	
<?php else : ?>

	<!----------------------------------------->
	<!-- STOP SESSION FORM -->
	<!----------------------------------------->
	
    <?= $this->Form->create($session, array('url' => array('controller' => 'sessions', 'action' => 'edit'))) ?>
    <fieldset>
		<table class="sessionTable">
		
		<?php 
			$start = $session->created;
			$now = new DateTime('now', new DateTimeZone($timezone));
			$interval = $start->diff($now);
						
			echo '<tr><td><strong>Elapsed Time:</strong></td><td>' . $interval->format('%H:%I') . '</td></tr>'; 			
			echo '<tr><td><strong>Project:</strong></td><td>' . $session->project['name'] . '<td/></tr>';
			echo '<tr><td><strong>Task:</strong></td><td>' . $session->task['name'] . '<td/></tr>';
			echo '<tr><td><strong>Start Time:</strong></td><td>' . $startTime->format('H:i') . '<td/></tr>';
			echo '<tr><td><strong>Current Time:</strong></td><td>' . $now->format('H:i') . '<td/></tr>';
			
            echo $this->Form->input('sessionId', array('value' => $session['id'], 'type' => 'hidden'));
		?>
		
		</table>
    </fieldset>
    <?= $this->Form->button(__('STOP SESSION'), ['style' => 'font-weight: bold; font-size: 150%; background: red;']) ?>
    <?= $this->Form->end() ?>	

<?php endif; ?>
	
</div>

<!------------------------------------------------------------------------------------------------->
<!-- SESSIONS -->
<!------------------------------------------------------------------------------------------------->

<?php

	//
	// first get total time for the day to show in the header
	//

	/*
	$totalTime = new DateTime('2000-01-01');
	
	foreach ($sessions as $session)
	{
		$start = new DateTime($session['created']);
		$stop = new DateTime($session['stopped']);
		$interval = $start->diff($stop);
		//$totalTime->add($interval);
	}
	*/

?>

<div class="sessions index large-9 medium-8 columns content">
    <h3><?= __('Total Time: ' . $totalTime->format("H:i")) ?><span style="color: gray; font-size: 70%;">&nbsp;(HH:MM)</span></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('Time (HH:MM)') ?></th>
                <th><?= $this->Paginator->sort('state') ?></th>
                <th><?= $this->Paginator->sort('project_id') ?></th>
                <th><?= $this->Paginator->sort('task_id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('stopped') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php 
				foreach ($sessions as $rec): 
			?>

			<?php
				//
				// fix timezone
				//				
				if (isset($rec->stopped))
					$rec->stopped->timezone = $timezone;
				
				if (isset($rec->created))
					$rec->created->timezone = $timezone;
					
				//dump($rec);die;
			?>
			
            <tr>
                <td><?= $this->Number->format($rec->id) ?></td>
                <td><?= $rec->timeLapse . ' (' . $rec->totalTime . ')' ?></td>				
                <td><?= $rec->stateDesc ?></td>
                <td><?= $rec->has('project') ? $this->Html->link($rec->project->name, ['controller' => 'Projects', 'action' => 'view', $rec->project->id]) : '' ?></td>
                <td><?= $rec->has('task') ? $this->Html->link($rec->task->name, ['controller' => 'Tasks', 'action' => 'view', $rec->task->id]) : '' ?></td>
                <td><?= h($rec->created) ?></td>
                <td><?= h($rec->stopped) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $rec->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $rec->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $rec->id, 'start'], ['confirm' => __('Are you sure you want to delete # {0}?', $rec->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
			<tr>
				<td><strong>TOTAL:</strong></td><td><?= $totalTime->format("H:i") ?></td>
			</tr>
        </tbody>
    </table>
</div>
