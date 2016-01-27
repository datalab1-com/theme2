
<?php echo $this->element('group-menu'); ?>

<div class="kbase index large-9 medium-8 columns content">

    <h3><?php echo $title; ?></h3>

    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('title') ?></th>
                <th><?= $this->Paginator->sort('text') ?></th>
                <th><?= $this->Paginator->sort('category') ?></th>
                <th><?= $this->Paginator->sort('order') ?></th>
                <th><?= $this->Paginator->sort('image') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($kbase as $kbase): ?>
            <tr>
                <td><?= $this->html->link($kbase->title, '/kbase/view/' . $kbase->id); ?></td>
                <td><?= substr(h($kbase->description), 0, 100); ?></td>
                <td><?= h($kbase->category->name) ?></td>
                <td><?= h($kbase->_order) ?></td>
                <td><?= h($kbase->image) ?></td>
                <td><?= h($kbase->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $kbase->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $kbase->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $kbase->id], ['confirm' => __('Are you sure you want to delete # {0}?', $kbase->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
