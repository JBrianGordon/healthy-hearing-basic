<?php
/**
 * @var \App\View\AppView $this
 */

// use Cake\View\Helper\FormHelper;
$userId = $this->Identity->getId();
?>

<div class="btn-toolbar mb-1" role="toolbar" aria-label="Toolbar with button groups">
    <?php foreach ($crmSearches as $crmSearch) : ?>
        <?php if ($crmSearch->is_public): ?>
            <div class="btn-group btn-group-xs m-1" role="group">
                <?php
                    echo $this->Form->postLink(
                        '<i class="bi bi-trash"></i>',
                        [
                            'controller' => 'CrmSearches',
                            'prefix' => 'Admin',
                            'action' => 'delete',
                            $crmSearch['id'],
                        ],
                        [
                            'class' => 'btn btn-danger rounded-start',
                            'confirm' => 'Are you sure?',
                            'escape' => false,
                        ]
                    );
                    echo $this->Html->link(
                        '<i class="bi bi-pencil"></i>',
                        [
                            'controller' => 'CrmSearches',
                            'prefix' => 'Admin',
                            'action' => 'edit',
                            $crmSearch['id'],
                        ],
                        [
                            'class' => 'btn btn-default',
                            'escape' => false,
                        ]
                    );
                    echo $this->Html->link(
                        $crmSearch['title'],
                        [
                            'prefix' => 'Admin',
                            'action' => 'index',
                            '?' => json_decode($crmSearch['search']),
                        ],
                        ['class' => 'btn btn-default']
                    );
                ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <?php foreach ($crmSearches as $crmSearch) : ?>
        <?php if (!$crmSearch->is_public && ($crmSearch->user_id == $userId)): ?>
            <div class="btn-group btn-group-xs m-1" role="group">
                <?php
                    echo $this->Form->postLink(
                        '<i class="bi bi-trash"></i>',
                        [
                            'controller' => 'CrmSearches',
                            'prefix' => 'Admin',
                            'action' => 'delete',
                            $crmSearch['id'],
                        ],
                        [
                            'class' => 'btn btn-danger rounded-start',
                            'confirm' => 'Are you sure?',
                            'escape' => false,
                        ]
                    );
                    echo $this->Html->link(
                        '<i class="bi bi-pencil"></i>',
                        [
                            'controller' => 'CrmSearches',
                            'prefix' => 'Admin',
                            'action' => 'edit',
                            $crmSearch['id'],
                        ],
                        [
                            'class' => 'btn btn-info',
                            'escape' => false,
                        ]
                    );
                    echo $this->Html->link(
                        $crmSearch['title'],
                        [
                            'prefix' => 'Admin',
                            'action' => 'index',
                            '?' => json_decode($crmSearch['search']),
                        ],
                        ['class' => 'btn btn-info']
                    );
                ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <?php if ($_isSearch === true && $savedSearch === false) : ?>
        <div class="btn-group btn-group-xs m-1" role="group">
            <?php
                echo $this->Form->postLink(
                    '+ Save This Search',
                    [
                        'controller' => 'CrmSearches',
                        'prefix' => 'Admin',
                        'action' => 'save',
                    ],
                    [
                        'class' => 'btn btn-primary rounded',
                        'data' => [
                            'searchData' => $_searchParams,
                            'model' => $currentModel,
                            'userId' => $this->Identity->getId(),
                        ],
                        'escape' => false,
                    ]
                );
            ?>
        </div>
    <?php endif; ?>
</div>
