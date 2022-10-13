<?php $this->Html->script('dist/content.min', ['block' => true]); ?>
<h1>Reports</h1>
<table>
    <tr>
        <th>Title</th>
        <th>Created</th>
    </tr>

    <?php foreach ($reports as $report): ?>
    <tr>
        <td>
            <?= $this->Html->link($report->title, $report->hh_url) ?>
        </td>
        <td>
            <?= $report->modified ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <ul class="pagination">
        <?=
            $this->Paginator->options([
                'url' => [
                    'controller' => 'content',
                    'action' => 'report_index'
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