<?php
namespace App\Error;

use Cake\Error\ExceptionRenderer;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Exception\GoneException;

class AppExceptionRenderer extends ExceptionRenderer
{
    public function notFound($error)
    {
        if ($error instanceof NotFoundException) {
            $this->controller->render('/Error/error404');
            $this->controller->response = $this->controller->response->withStatus(404);
            return $this->controller->response;
        } elseif ($error instanceof GoneException) {
            $this->controller->render('/Error/error410');
            $this->controller->response = $this->controller->response->withStatus(410);
            return $this->controller->response;
        }
    }
}
?>