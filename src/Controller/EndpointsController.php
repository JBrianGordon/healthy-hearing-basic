<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Firebase\JWT\JWT;

class EndpointsController extends Controller
{
    public function ckeditorEndpoint()
    {
        $user = $this->request->getSession()->read('Auth');
        $userRole = ($user && $user['role'] === 'admin') ? 'admin' : 'user';

        $accessKey = 'GruAKE1qtAen5lwdhiJbsn3z0ieiQ6JKfdDa5fTH0zK2sapn9fcfr0lWOZi6';
        $environmentId = Configure::read('ckEditorEnvironmentId');

        $payload = [
            'aud' => $environmentId,
            'iat' => time(),
            'sub' => 'finance@healthyhearing.com',
            'auth' => [
                'ckbox' => [
                    'role' => $userRole,
                ]
            ]
        ];

        $jwt = JWT::encode($payload, $accessKey, 'HS256');

        $this->response = $this->response->withType('application/json')->withStringBody(json_encode(['token' => $jwt]));

        return $this->response;
    }
}