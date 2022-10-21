<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Content $content
 */
 
$this->Html->script('dist/content.min', ['block' => true]);
?>

<h1><?= $content->title ?></h1>
<p><em><?= $this->Editorial->getAuthorsByline($content->primary_author, $content->contributors) ?></em></p>
<p><?= $content->body ?></p>

<?= $this->element('schema/person', ['author' => $content->primary_author]) ?>