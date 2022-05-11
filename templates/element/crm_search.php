<?php
/**
 * @var \App\View\AppView $this
 */

// use Cake\View\Helper\FormHelper;
?>

<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
    <?php foreach ($crmSearches as $crmSearch): ?>
        <div class="btn-group btn-group-sm m-1" role="group">
            <?php
                echo $this->Form->postLink('<i class="bi bi-trash"></i>',
                    [
                        'controller' => 'CrmSearches',
                        'prefix' => 'Admin',
                        'action' => 'delete',
                        $crmSearch['id']
                    ],
                    [
                        'class' => 'btn btn-danger rounded-start',
                        'confirm' => 'Are you sure?',
                        'escape' => false
                    ]
                );
                echo $this->Html->link('<i class="bi bi-pencil"></i>',
                    [
                        'controller' => 'CrmSearches',
                        'prefix' => 'Admin',
                        'action' => 'edit',
                        $crmSearch['id']
                    ],
                    [
                        'class' => 'btn btn-outline-secondary',
                        'escape' => false
                    ]
                );
                echo $this->Html->link($crmSearch['title'], [
                        'controller' => 'Content',
                        'prefix' => 'Admin',
                        'action' => 'index',
                        '?' => json_decode($crmSearch['search'])
                    ],
                    ['class' => 'btn btn-outline-secondary']
                );
            ?>
        </div>
    <?php endforeach; ?>
</div>