<?php echo $this->element('admin-menu'); ?>

<div class="kbase form large-9 medium-8 columns content">
    <?= $this->Form->create($kbase) ?>
    <fieldset>
        <legend><?= __('Edit Kbase') ?></legend>
        <?php
            echo $this->Form->input('user_id', ['options' => $users]);
            echo $this->Form->input('category_id');
            echo $this->Form->input('_order');
            echo $this->Form->input('title');
            echo $this->Form->input('subtitle');
            echo $this->Form->input('description');
            echo $this->Form->input('url');
            echo $this->Form->input('thumb');
            echo $this->Form->input('image');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
