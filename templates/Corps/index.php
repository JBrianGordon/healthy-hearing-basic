<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Corp[]|\Cake\Collection\CollectionInterface $corps
 */
?>
<h1>Corps</h1>
<table>
    <tr>
        <th>Title</th>
        <th>Created</th>
    </tr>

    <?php foreach ($corps as $corp): ?>
    <tr>
        <td>
            <?= $this->Html->link($corp->title, $corp->hh_url) ?>
        </td>
        <td>
            <?= $corp->modified ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <ul class="pagination">
        <?=
            $this->Paginator->options([
                'url' => [
                    'controller' => 'corps',
                    'action' => 'index'
                ]
            ]);
        ?>
        <?= $this->Paginator->prev(); ?>
        <?= $this->Paginator->numbers(['modulus' => 2]); ?>
        <?= $this->Paginator->next(">>"); ?>
        <?= $this->Paginator->first("FIRST"); ?>
        <?= $this->Paginator->last("LAST"); ?>
    </ul>
</table>