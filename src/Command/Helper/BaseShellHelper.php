<?php
namespace App\Command\Helper;
 
use Cake\Console\Helper;
 
class BaseShellHelper extends Helper
{
    public function output(array $args): void
    {
        $this->_io->out($args);
    }

    public function title($text = '') {
        $this->_io->out();
        $this->_io->hr();
        $this->_io->warning($text);
        $this->_io->hr();
    }
}
