<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wiki[]|\Cake\Collection\CollectionInterface $wikis
 */
?>
<h1>Wikis</h1>
<table>
    <tr>
        <th>Title</th>
        <th>Created</th>
    </tr>

    <?php foreach ($wikis as $wiki): ?>
    <tr>
        <td>
            <?= $this->Html->link($wiki->name, $wiki->hh_url) ?>
        </td>
        <td>
            <?= $wiki->modified ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <ul class="pagination">
        <?=
            $this->Paginator->options([
                'url' => [
                    'controller' => 'wikis',
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