<?php
use \App\Model\Entity\CaCallGroup;
foreach (CaCallGroup::$col1Topics as $topicKey => $label) {
	$hiddenInputs = ['topic_aid_lost_old', 'topic_aid_lost_new', 'topic_warranty_old', 'topic_warranty_new'];

	if ($topicKey == 'topic_aid_lost_old') {
		$topicAidLost = !empty($caCall->ca_call_group->topic_aid_lost_old) || !empty($caCall->ca_call_group->topic_aid_lost_new);
		echo $this->Form->control('ca_call_group.topic_aid_lost', [
			'type' => 'checkbox',
			'label' => [
				'style' => 'text-align:left;',
				'text' => '<span class="topic-label">Hearing aid lost/broken</span>',
			],
			'default' => $topicAidLost,
			'escape' => false
		]);
	}

	if ($topicKey == 'topic_warranty_old') {
		$topicWarranty = !empty($caCall->ca_call_group->topic_warranty_old) || !empty($caCall->ca_call_group->topic_warranty_new);
		echo $this->Form->control('ca_call_group.topic_warranty', [
			'type' => 'checkbox',
			'label' => [
				'style' => 'text-align:left;',
				'text' => '<span class="topic-label">Hearing aid warranty question</span>',
			],
			'default' => $topicWarranty,
			'escape' => false
		]);
	}

	if (in_array($topicKey, $hiddenInputs)) {
		echo '<div class="hidden checkbox '.$topicKey.'">';
			echo $this->Form->control('ca_call_group.'.$topicKey, [
				'type' => 'checkbox',
				'label' => [
					'style' => 'text-align:left;',
					'text' => '<span class="topic-label">'.$label.'</span>',
				],
				'escape' => false
			]);
		echo '</div>';				
	} else {
		echo $this->Form->control('ca_call_group.'.$topicKey, [
			'type' => 'checkbox',
			'label' => [
				'style' => 'text-align:left;',
				'text' => '<span class="topic-label">'.$label.'</span>',
			],
			'escape' => false
		]);
	}
}
?>	
