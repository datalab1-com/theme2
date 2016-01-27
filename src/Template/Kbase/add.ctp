<script>

$(document).ready(function() {

	$("#title").focus();
	
});

</script>

<?php echo $this->element('admin-menu'); ?>

<div class="kbase form large-9 medium-8 columns content">
    <?= $this->Form->create($kbase) ?>
    <fieldset>
        <legend><?= __('Add Kbase') ?></legend>
        <?php
            echo $this->Form->input('user_id', ['options' => $users]);
            echo $this->Form->input('category_id', ['default' => $categoryId]);
            echo $this->Form->input('_order', ['default' => 0]);
            echo $this->Form->input('title', ['id' => 'title']);
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
