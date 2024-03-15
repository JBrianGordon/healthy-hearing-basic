<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

?>

<?php echo 'Hi ' . Configure::read('siteName') . ' Admin,'; ?><br /><br />

<p>
	Your recent action (e.g. approval, denial, etc.) on the following review did not send an email to the <?= $this->Html->link('clinic', ['controller' => 'Locations', 'action' => 'edit', $reviewData['location_id'], '_full' => true]) ?> because their profile currently does not have an email address:
</p>
<p>
	<?=
		$this->Html->link(
			'Click to see Review',
			[
				'controller' => 'Reviews',
				'action' => 'edit',
				$reviewData['id'],
				'_full' => true
			],
		);
	?>
</p>
