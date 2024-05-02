<?php
namespace App\Controller\Clinic;

use App\Controller\AppController;

class LibraryItemsController extends BaseClinicController
{
    public function index()
    {
        // if (!$this->getConfigure('showSocialMediaContentLibrary')) {
        //     return $this->redirect(['clinic' => false, 'controller' => 'Pages', 'action' => 'home']);
        // }

        $this->loadModel('Content');

        $libraryItems = $this->Content->find()
            ->where([
                'Content.is_library_item' => true,
                'Content.is_active' => true,
                'Content.date <= CURDATE()'
            ])
            ->order(['Content.last_modified' => 'DESC'])
            ->all();

        $this->set(compact('libraryItems'));

        $pageContent = $this->getTableLocator()->get('Pages')->getContent('library');
        $this->set(compact('pageContent'));
    }
}
?>