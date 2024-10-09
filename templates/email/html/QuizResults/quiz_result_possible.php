<p>Hello <?= $name ?>,</p>

<p>Thank you for taking our online hearing test!</p>

<p>Your answers reveal you may have at least mild hearing loss. You reported occasional difficulty in situations that are challenging for many people with hearing loss. For example, you indicated:</p>

<ul>
	<?php foreach ($symptoms as $symptom): ?>
		<li><?= $symptom ?></li>
	<?php endforeach ?>
</ul>

<p>Did you know even slight <?= $this->Html->link('hearing loss', $this->Html->url('/report/53057-Very-mild-forms-of-hearing-loss-linked-to-cognitive-decline-in-new-study', ['fullBase' => true])) ?> is linked to cognitive decline? Now is the best time to get screened. Schedule a hearing test today, get answers and get help. <?= $this->Html->link('Find a clinic near you', $this->Html->url($this->Clinic->nearMeLink(),['fullBase' => true])) ?>.</p>

<p>The good news? <?= $this->Html->link('Hearing aids', $this->Html->url('/help/hearing-aids', ['fullBase' => true])) ?> can delay the onset of dementia and provide many other <?= $this->Html->link('health benefits', $this->Html->url('/help/hearing-aids/health-benefits', ['fullBase' => true])) ?>.
Hearing health is important, so please share this <?= $this->Html->link('online hearing test', $this->Html->url('/help/online-hearing-test', ['fullBase' => true])) ?> with friends and family.</p>

<p>Sincerely,</p>
<p>Your friends at <?= Configure::read('siteName') ?></p>