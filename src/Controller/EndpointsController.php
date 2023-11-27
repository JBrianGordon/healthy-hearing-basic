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

        //Set workspace ID and role if it exists
        $this->user = $this->request->getSession()->read('Auth');
        $userWorkspace = $this->user->workspace_id ?? this->user->workspace_id;
        $userRole = ($this->user->role === 'admin') ? 'superadmin' : 'user';
        $this->set('userWorkspace', $userWorkspace);
        $this->set('userRole', $userRole);

        // Render the template without layout
        return $this->render('/Endpoints/ckeditor_endpoint');
    }
    public function tinymceEndpoint()
    {
        // Disable the auto layout
        $this->viewBuilder()->disableAutoLayout();

        // Render the template without layout
        return $this->render('/Endpoints/tinymce_endpoint');
    }
}
?>