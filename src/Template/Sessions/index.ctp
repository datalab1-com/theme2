<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Session'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tasks'), ['controller' => 'Tasks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Task'), ['controller' => 'Tasks', 'action' => 'add']) ?></li>
    </ul>
</nav>

<div class="sessions index large-9 medium-8 columns content">

<?= $this->Html->link(__('Today'), ['action' => 'index', 0]) ?>
<span>&nbsp; &nbsp;</span>
<?= $this->Html->link(__('Yesterday'), ['action' => 'index', -1]) ?>

    <h3><?= __('Timer Sessions') ?></h3>
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
            <?php foreach ($sessions as $session): ?>

			<?php	
				$timezone = "America/Chicago";
				
				if (isset($session->stopped))
					$session->stopped->timezone = $timezone;
				
				if (isset($session->created))
					$session->created->timezone = $timezone;
			?>
			
            <tr>
                <td><?= $this->Number->format($session->id) ?></td>
                <td><?= $session->timeLapse ?></td>				
                <td><?= $session->stateDesc ?></td>
                <td><?= $session->has('project') ? $this->Html->link($session->project->name, ['controller' => 'Projects', 'action' => 'view', $session->project->id]) : '' ?></td>
                <td><?= $session->has('task') ? $this->Html->link($session->task->name, ['controller' => 'Tasks', 'action' => 'view', $session->task->id]) : '' ?></td>
                <td><?= h($session->created) ?></td>
                <td><?= h($session->stopped) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $session->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $session->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $session->id, 'index'], ['confirm' => __('Are you sure you want to delete # {0}?', $session->id)]) ?>
                </td>
            </tr>			
            <?php endforeach; ?>
			<?php if (isset($totalTime)) : ?>
			<tr>
				<td><strong>TOTAL:</strong></td><td><?= $totalTime->format("H:i") ?></td>
			</tr>
			<?php endif; ?>
        </tbody>
    </table>
	<?php 

	if (isset($this->Paginator->numbers)) : ?>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
	<?php endif; ?>
</div>
