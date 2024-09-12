<?php 
use Cake\ORM\TableRegistry;

if(isset($contact)){
    foreach(['company','first_name','last_name','zip','phone','email'] as $field){
        if(isset($contact[$field]) && !empty($contact[$field])){
            if($field == 'zip'){
                echo ucfirst(Configure::read('zipLabel')) . ": " . $contact[$field] . '<br>';
                $locations = TableRegistry::getTableLocator()->get('Location');
                $zipUrl = Router::url($locations->findUrlByZip($contact[$field]), true);
                echo ucfirst(Configure::read('zipLabel')) . " URL: " .
                    '<a href="' . $zipUrl . '">' . $zipUrl . '</a><br>';
            } else {
                echo humanize($field) . ": " . $contact[$field] . '<br>';
            }
        }
    }
}
?>