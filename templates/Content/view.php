<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Content $content
 */
?>

<h1><?= $content->title ?></h1>
<p><em>Contributed by <?= $content->primary_author->full_personal_info ?></em></p>
<p><?= $content->body ?></p>

<?= $this->element('schema/person', ['author' => $content->primary_author]) ?>