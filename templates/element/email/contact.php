<?php 
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Routing\Router;

if(isset($requestData)){
    foreach(['company','first_name','last_name','zip','phone','email'] as $field){
        if(isset($requestData[$field]) && !empty($requestData[$field])){
            if($field == 'zip'){
                echo ucfirst(Configure::read('zipLabel')) . ": " . $requestData[$field] . '<br>';
                $locations = TableRegistry::getTableLocator()->get('Location');
                $zipUrl = Router::url($locations->findUrlByZip($requestData[$field]), true);
                echo ucfirst(Configure::read('zipLabel')) . " URL: " .
                    '<a href="' . $zipUrl . '">' . $zipUrl . '</a><br>';
            } else {
                echo humanize($field) . ": " . $requestData[$field] . '<br>';
            }
        }
    }
}
?>