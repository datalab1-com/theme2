<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $session->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $session->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Sessions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tasks'), ['controller' => 'Tasks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Task'), ['controller' => 'Tasks', 'action' => 'add']) ?></li>
    </ul>
</nav>

<!--div class="sessions form large-9 medium-8 columns content"-->
<div class="sessions form large-9 medium-8 columns content">
    <?= $this->Form->create($session, ['class' => 'form-style-10']) ?>
    <fieldset>
        <legend><?= __('Edit Session') ?></legend>
        <?php
            //echo $this->Form->input('user_id');
            echo $this->Form->input('project_id', ['options' => $projects]);
            echo $this->Form->input('task_id', ['options' => $tasks]);
            echo $this->Form->input('created', ['id' => 'created_date']);
            echo $this->Form->input('stopped');
            echo $this->Form->input('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
