<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Core\Configure;

class ViteHelper extends Helper
{
    public function viteClient()
    {
        $env = Configure::read('env');
        if ($env === 'local') {
            return $this->_View->Html->script('http://localhost:5173/@vite/client', [
                'type' => 'module',
                'block' => true
            ]);
        }
        return '';
    }

    public function script($parentDir = '', $filename)
    {
        $env = Configure::read('env');
        if ($env === 'local') {
            // Output Vite client and the script
            return $this->viteClient() .
                $this->_View->Html->script("http://localhost:5173/js/{$parentDir}/{$filename}.ts", [
                    'type' => 'module',
                    'block' => true
                ]);
        } else {
            return $this->_View->Html->script("/js/dist-vite/{$filename}.min.js", [
                'type' => 'module',
                'block' => true
            ]);
        }
    }
}
?>