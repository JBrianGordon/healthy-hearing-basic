<?php
use Cake\Core\Configure;
?>
<div id="exportModal" class="modal-dialog modal-lg modal fade" style="position:fixed; max-height:100vh; right:0">
  <div class="modal-content">
    <div class="modal-body tac" style="width: 100%">
      <h4>Please choose which fields you would like to appear in your export:</h4>
      <span id="exportClose">X</span>
      <label class="switch export-label" id="allFields">
        <p>Toggle all on/off</p>
        <input class="form-control switch-positive hidden" placeholder="0 [or] 1" type="text" id="allFieldsInput">
        <span class="slider">
          <span class="switch-negative"></span>
          <span class="switch-positive"></span>
        </span>
      </label>
      <?php
        $searchFields = Configure::read('locationExportFields');
        if(Configure::read('locationExportFieldOverrides')) {
          $overrideFields = Configure::read('locationExportFieldOverrides');
        }
        $indexCount = 1;
        array_push($searchFields, 'additional_emails', 'provider_emails', 'hh_username', 'hh_url', 'cs_calls', 'cs_usable_calls', 'cs_missed_calls', 'cs_prospects', 'cs_appt_set');
        if (Configure::read('isCallAssistEnabled')) {
          array_push($searchFields, 'call_groups', 'usable_calls', 'prospects', 'appt_set', 'all_calls' , 'all_usable_calls', 'all_prospects', 'all_appt_set');
        }
        if (Configure::read('isTieringEnabled')) {
          array_push($searchFields, 'add_on_flex_space', 'add_on_content_library', 'using_logo', 'using_flex_space', 'using_photos', 'using_badges', 'using_linked_locations');
        }
        foreach ($searchFields as $searchField) {
          if ($indexCount++ % 3 == 0) {
            echo '<div class="col-xs-4">';
          } else {
            echo '<div class="col-xs-4 border-right">';
          }
          //Change field names for CA
          if(!empty($overrideFields)){
            $searchString = strval($searchField);
            if(array_key_exists($searchString, $overrideFields)){
              $searchField = ucfirst($overrideFields[$searchString]);
            }
          }
          $spacedField = str_replace('_', ' ', $searchField);
          if (strpos($spacedField, 'LocationUser.') >= 0) {
            $spacedField = str_replace('LocationUser.', '', $spacedField);
            $searchField = str_replace('LocationUser.', '', $searchField);
          }
          $spacedField = ucfirst($spacedField);
          //Change Cs to CT for label
          if (strpos($spacedField, 'Cs') >= 0) {
            $spacedField = str_replace('Cs', 'CT', $spacedField);
          }

          //Uppercase Hh to HH (or Hd to HD)
          if (strpos($spacedField, 'Hh') >= 0 && strpos($spacedField, 'Hh') < 3) {
            $spacedField = str_replace('Hh', 'HH', $spacedField);
          }
          if (strpos($spacedField, 'Hd') >= 0 && strpos($spacedField, 'Hd') < 3) {
            $spacedField = str_replace('Hd', 'HD', $spacedField);
          }
          echo '<label class="switch export-label mb10"><p>' . $spacedField . '</p><input class="form-control switch-positive hidden" type="text" value="1" name="' . $searchField . '"><span class="slider"><span class="switch-negative"></span><span class="switch-positive"></span></span></label></div>';
        }
      ?>
      <button type="button" class="close-modal btn btn-lg btn-light" data-bs-dismiss="modal" aria-hidden="true" id="exportSubmit">Ok</button>
    </div>
  </div>
</div>
