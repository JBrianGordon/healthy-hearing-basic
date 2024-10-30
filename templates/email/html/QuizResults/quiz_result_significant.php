<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;
use Cake\Routing\Router;

?>
<p>Hello <?= $name ?>,</p>

<p>Thank you for taking our online hearing test!</p>

<p>Your answers reveal you likely have significant hearing loss. You told us you have frequent difficulty in situations that are challenging for many other people with hearing loss. For example, you reported:</p>

<ul>
	<?php foreach ($symptoms as $symptom): ?>
		<li><?= $symptom ?></li>
	<?php endforeach ?>
</ul>

<p>Don’t make the same mistake so many people with hearing loss do! Stop procrastinating - now is the best time to get help for your hearing loss. Schedule a hearing test today, get answers and get help. <?= $this->Html->link('Find a clinic near you', Router::url($this->Clinic->nearMeLink(),true)) ?>.</p>

<p>Untreated hearing loss is linked to many negative health impacts, including <?= $isUS ? $this->Html->link('cognitive decline', Router::url('/report/52904-The-connection-between-hearing-loss-and-cognitive-decline', true)) : 'cognitive decline' ?>. The good news? <?= $this->Html->link('Hearing aids', Router::url('/help/hearing-aids', true)) ?> can delay the onset of dementia and provide many other <?= $this->Html->link('health benefits', Router::url('/help/hearing-aids/health-benefits', true)) ?>.</p>

<p>Hearing health is important, so please share this <?= $this->Html->link('online hearing test', Router::url('/help/online-hearing-test', true)) ?> with friends and family.</p>

<p>Sincerely,</p>
<p>Your friends at <?= Configure::read('siteName') ?></p>