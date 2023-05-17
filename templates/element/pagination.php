<?php
$options = isset($options) ? $options : [];
?>
<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->first('« ' . __('First'), $options) ?>
        <?= $this->Paginator->prev('‹ ' . __('Previous'), $options) ?>
        <?= $this->Paginator->numbers($options) ?>
        <?= $this->Paginator->next(__('Next') . ' ›', $options) ?>
        <?= $this->Paginator->last(__('Last') . ' »', $options) ?>
    </ul>
    <p class="text-primary text-small text-uppercase"><strong><?= $this->Paginator->counter(__('Page {{page}} of {{pages}} - {{count}} results')) ?></strong></p>
</div>
