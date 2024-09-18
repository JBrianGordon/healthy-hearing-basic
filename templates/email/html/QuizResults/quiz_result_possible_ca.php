<p>Hello <?= $name ?>,</p>

<p>Thank you for taking our online hearing test!</p>

<p>Your answers reveal you may have at least mild hearing loss. You reported occasional difficulty in situations that are challenging for many people with hearing loss. For example, you indicated:</p>

<ul>
	<?php foreach ($symptoms as $symptom): ?>
		<li><?= $symptom ?></li>
	<?php endforeach ?>
</ul>

<p>Did you know even slight <?= $this->Html->link('hearing loss', $this->Html->url('/help/hearing-loss', true)) ?> is linked to many negative health impacts, including anxiety, depression and cognitive decline? Now is the best time to get screened. Schedule a <?= $this->Html->link('hearing test', $this->Html->url('/help/hearing-loss/tests', true)) ?> today, get answers and get help. <?= $this->Html->link('Find a clinic near you', $this->Html->url($this->Clinic->nearMeLink(),true)) ?>.</p>

<p>The good news? <?= $this->Html->link('Hearing aids', $this->Html->url('/help/hearing-aids', true)) ?> can provide many <?= $this->Html->link('health benefits', $this->Html->url('/help/hearing-loss/treatment', true)) ?> and improve overall quality of life. Hearing health is important, so go ahead and share this <?= $this->Html->link('online hearing test', $this->Html->url('/help/online-hearing-test', true)) ?> with friends and family.</p>

<p>Sincerely,</p>
<p>The <?= Configure::read('siteName') ?> Team</p>