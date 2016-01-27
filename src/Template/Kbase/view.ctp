<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Kbase'), ['action' => 'edit', $kbase->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Kbase'), ['action' => 'delete', $kbase->id], ['confirm' => __('Are you sure you want to delete # {0}?', $kbase->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Kbase'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Kbase'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="kbase view large-9 medium-8 columns content">
    <h3><?= h($kbase->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $kbase->has('user') ? $this->Html->link($kbase->user->id, ['controller' => 'Users', 'action' => 'view', $kbase->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Title') ?></th>
            <td><?= h($kbase->title) ?></td>
        </tr>
        <tr>
            <th><?= __('Subtitle') ?></th>
            <td><?= h($kbase->subtitle) ?></td>
        </tr>
        <tr>
            <th><?= __('Thumb') ?></th>
            <td><?= h($kbase->thumb) ?></td>
        </tr>
        <tr>
            <th><?= __('Image') ?></th>
            <td><?= h($kbase->image) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($kbase->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Category Id') ?></th>
            <td><?= $this->Number->format($kbase->category_id) ?></td>
        </tr>
        <tr>
            <th><?= __(' Order') ?></th>
            <td><?= $this->Number->format($kbase->_order) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($kbase->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($kbase->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($kbase->description)); ?>
    </div>
    <div class="row">
        <h4><?= __('Url') ?></h4>
        <?= $this->Text->autoParagraph(h($kbase->url)); ?>
    </div>
</div>
