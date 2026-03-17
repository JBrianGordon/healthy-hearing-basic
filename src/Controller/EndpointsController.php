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
        $userRole = ($user && $user['role'] === 'admin') ? 'superadmin' : 'user';

        $accessKey = Configure::read('ckEditorAccessKey');
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

        try {
            $jwt = JWT::encode($payload, $accessKey, 'HS256');
            // Return the token as a response
            return $this->response->withStringBody($jwt);
        } catch (\Exception $e) {
            // Handle errors and return a JSON response
            $error = ['error' => $e->getMessage()];
            return $this->response->withType('application/json')->withStringBody(json_encode($error));
        }
    }
}