<?php
$locationsPage = ($this->request->getParam('controller') == 'Locations') ? true : false;
if ($locationsPage) {
    $handleText = 'Schedule a hearing test';
} else {
    $handleText = 'Connect with clinics near me';
}

// Set in respective controllers
$show_slider = isset($show_slider) ? $show_slider : true;
if ($this->Clinic->isDifferentCountry()) {
    $show_slider = false;
}
?>
<?php if ($show_slider): ?>
    <?php $this->append('bs-modals'); ?>
    <div data-hh-sticky-panel id="hh-sticky-panel">
        <div class="sticky-panel-handle">
            <span class="handle-text"><?php echo $handleText; ?></span>
            <span class="close-icon"></span>
        </div>
        <div class="sticky-panel-body">
            <?php if (!$locationsPage): ?>
                <p class="text-large">Find a trusted clinic near me:</p>
                <?php echo $this->element('locations/search', [
                    'label' => 'Enter city',
                    'form_id' => 'sliderform',
                    'auto_id' => 'SliderSearchId',
                    'search_id' => 'SliderSearch',
                    'btnId' => 'SliderSearchBtn',
                    'autocomplete' => true
                ]); ?>
            <?php endif; ?>
            <?php echo $this->element('fac_config_text', ["locationsPage" => $locationsPage]); ?>
        </div>
    </div>
    <?php $this->end(); ?>
<?php endif; ?>
