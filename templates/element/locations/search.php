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
$class = $autocomplete ? 'form-control autocomplete' : 'form-control'; 
?>


<?= $this->Form->create();
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
			'wrapInput' => false
		]); ?>
		<span class="input-group-btn">
			<button class="btn btn-secondary" id="<?= $btnId; ?>" type="submit">Search</button>
		</span>
	</div>
<?= $this->Form->end(); ?>