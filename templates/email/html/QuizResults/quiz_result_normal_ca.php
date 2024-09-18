<p>Hello <?= $name ?>,</p>

<p>Thank you for taking our online hearing test!</p>

<p>Your answers reveal you likely have normal hearing. However, getting a hearing screening is the first step to better overall health and you may still want to speak with a hearing care provider who can provide you with a thorough assessment of your hearing. Use our nation-wide <?= $this->Html->link('directory', $this->Html->url($this->Clinic->nearMeLink(),true)) ?> to find a hearing clinic near you.</p>

<p>Did you know you can <?= $this->Html->link('prevent hearing loss', $this->Html->url('/help/hearing-loss/prevention', true)) ?>? A healthy lifestyle and reducing your noise exposure can go a long way.</p>

<p>Hearing health is important, so go ahead and share this <?= $this->Html->link('online hearing test', $this->Html->url('/help/online-hearing-test', true)) ?> with friends and family. Untreated <?= $this->Html->link('hearing loss', $this->Html->url('/help/hearing-loss', true)) ?> is linked to many negative health impacts, including anxiety, depression and cognitive decline. The good news? <?= $this->Html->link('Hearing aids', $this->Html->url('/help/hearing-aids', true)) ?> can provide many <?= $this->Html->link('health benefits', $this->Html->url('/help/hearing-loss/treatment', true)) ?> and improve overall quality of life.</p>

<p>Sincerely,</p>
<p>The <?= Configure::read('siteName') ?> Team</p>