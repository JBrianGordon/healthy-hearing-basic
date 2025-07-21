<?php
$label = isset($label) ? $label : "City, ".$stateLabel." or ".$zipShort;
$popup = isset($popup) ? $popup : false;
$buffer = isset($buffer) ? $buffer : true;
$autocomplete = isset($autocomplete) ? $autocomplete : true;
$form_id = isset($form_id) ? $form_id : 'FapMegaSearch';
$auto_id = isset($auto_id) ? $auto_id : 'LocationSearchId';
$search_id = isset($search_id) ? $search_id : 'LocationSearch';
$btnId = isset($btnId) ? $btnId : 'LocationSearchBtn';
$inline = isset($inline) ? $inline : false;
$class = $autocomplete ? 'form-control autocomplete col-12 mb15 autoCompleteJs' : 'form-control'; 
?>


<?= $this->Form->create(null, ['role' => 'search']);
	/*** TODO: leftover code from B3F, see if it's still need once search functionality is built out ***: Location', [
	'url' => '/search',
	'inputDefaults' => array(
		'label' => false,
		'div' => false,
	),
	'id' => $form_id,
	'class' => $inline ? 'form-inline' : 'form-group',
]);*/ ?>
	<?php
	if ($popup) {
		echo $this->Form->input('fap_popup', ['type' => 'hidden', 'value' => 1]);
	}
	?>

	<div class="input-group">
		<?= $this->Form->hidden('search_id', ['value' => '', 'id' => $auto_id, 'class' => 'auto-id']); ?>
		<?= $this->Form->input('search', [
			'type' => 'text',
			'class' => $class,
			'placeholder' => $label,
			'id' => $search_id,
			'label' => 'Enter city or zip/postal code',
			'style' => 'height:48px;width:100%'
		]); ?>
	</div>
<?= $this->Form->end(); ?>