<div id="admin_filter" class="pull-right col-md-4 pr0">
    <?= $this->Form->create(null, ['id' => "{$modelName}IndexForm"]) ?>
    <div style="display:none;">
        <?= $this->Form->hidden('_method', ['value' => 'POST']) ?>
    </div>
    <div class="input-group">
        <div class="input text">
            <?= $this->Form->control('q', ['label' => false, 'placeholder' => "{$modelName} Search", 'class' => 'form-control w-100 rounded-0', 'id' => "{$modelName}Filter", 'value' => $this->request->getQuery('q')]) ?>
        </div>				
        <span class="input-group-btn position-relative">
            <?= $this->Form->button(' Search', ['type' => 'submit', 'class' => 'btn btn-default bi bi-search rounded-0', 'style' => 'height:46px']) ?>
        </span>
    </div>
    <?= $this->Form->end() ?>
</div>