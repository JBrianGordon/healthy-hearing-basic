<p>Hello <?= $name ?>,</p>

<p>Thank you for taking our online hearing test!</p>

<p>Your answers reveal you probably have normal hearing. However, since you were concerned enough to take our test, you may still want to see a hearing care specialist. Use our <?= $this->Html->link('directory', $this->Html->url($this->Clinic->nearMeLink(),true)) ?> to find one near you.</p>

<p>Did you know you can prevent <?= $this->Html->link('hearing loss', $this->Html->url('/help/hearing-loss/prevention', true)) ?>? A healthy lifestyle and reducing your <?= $this->Html->link('noise exposure', $this->Html->url('/help/hearing-loss/noise-induced-hearing-loss', true)) ?> can go a long way.</p>

<p>Hearing health is important, so please share this <?= $this->Html->link('online hearing test', $this->Html->url('/help/online-hearing-test', true)) ?> with friends and family. Untreated hearing loss is linked to many negative health impacts, including <?= $this->Html->link('cognitive decline', $this->Html->url('/report/52904-The-connection-between-hearing-loss-and-cognitive-decline', true)) ?>. The good news? <?= $this->Html->link('Hearing aids', $this->Html->url('/help/hearing-aids', true)); ?> can delay the onset of dementia and provide many other <?= $this->Html->link('health benefits', $this->Html->url('/help/hearing-aids/health-benefits', true)); ?>.</p>

<p>Sincerely,</p>
<p>Your friends at Healthy Hearing</p>