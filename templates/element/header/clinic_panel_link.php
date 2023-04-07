<li>
	<?php
		echo $this->AuthLink->link(
			'<i class="bi bi-person-fill"></i>',
			[
				'prefix' => 'Clinic',
				'controller' => 'Locations',
				'action' => 'edit',
				$this->Identity->get('locations.0.id')
			],
			[
				'escape' => false,
				'class'=>'nav-link'
			]
		);
	?>
</li>