<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\View\View;

class EndpointsController extends Controller
{
    public function ckeditorEndpoint()
    {
        // Disable the auto layout
        $this->viewBuilder()->disableAutoLayout();

        // Render the template without layout
        return $this->render('/Endpoints/ckeditor_endpoint');
    }
}
?>