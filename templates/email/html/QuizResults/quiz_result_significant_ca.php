<p>Hello <?= $name ?>,</p>

<p>Thank you for taking our online hearing test!</p>

<p>Your answers reveal you likely have significant hearing loss. You told us you have frequent difficulty in situations that are challenging for many other people with hearing loss. For example, you reported:</p>

<ul>
	<?php foreach ($symptoms as $symptom): ?>
		<li><?= $symptom ?></li>
	<?php endforeach ?>
</ul>

<p>Don’t make the same mistake so many people with hearing loss do! Don't delay another day - now is the best time to get help for your <?= $this->Html->link('hearing loss', $this->Html->url('/help/hearing-loss', true)) ?>. Schedule a <?= $this->Html->link('hearing test', $this->Html->url('/help/hearing-loss/tests', true)) ?> today, get answers and get help. <?= $this->Html->link('Find a clinic near you', $this->Html->url($this->Clinic->nearMeLink(),true)) ?>.</p>

<p>Untreated hearing loss is linked to many negative health impacts, including anxiety, depression and cognitive decline. The good news? <?= $this->Html->link('Hearing aids', $this->Html->url('/help/hearing-aids', true)) ?> can provide many <?= $this->Html->link('health benefits', $this->Html->url('/help/hearing-loss/treatment', true)) ?> and improve overall quality of life.</p>

<p>Hearing health is important, so be sure to share this <?= $this->Html->link('online hearing test', $this->Html->url('/help/online-hearing-test', true)) ?> with friends and family.</p>

<p>Sincerely,</p>
<p>The <?= Configure::read('siteName') ?> Team</p>