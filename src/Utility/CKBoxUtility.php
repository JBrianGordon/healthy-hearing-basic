<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\Core\Configure;
use Firebase\JWT\JWT;

class CKBoxUtility
{
    private $apiKey;
    private $apiUrl;
    private $envId;
    private $apiSecret;
    private $userId;
    private $role;

    public function __construct()
    {
        $this->apiUrl = 'https://api.ckbox.io/assets';
        $this->envId = Configure::read('CK.envId');
        $this->apiSecret = Configure::read('CK.apiSecret');
        $this->userId = Configure::read('CK.userId');
        $this->role = Configure::read('CK.role');
        $this->categoryId = Configure::read('CK.categoryId-testing');
    }

    public function generateToken($userId, $role)
    {
        $payload = [
            'aud' => $this->envId,
            'sub' => $userId,
            'iat' => time(),
            'auth' => [
                'ckbox' => [
                    'role' => $role
                ]
            ],
        ];

        return JWT::encode($payload, $this->apiSecret, 'HS256');
    }

    public function uploadImage($imageData)
    {
        // Authorization token
        $token = $this->generateToken($this->userId, $this->role);

        // Initialize cURL
        $ch = curl_init();

        // Set URL
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);

        // Set request method
        curl_setopt($ch, CURLOPT_POST, true);

        // Build the multi-part form data POST fields
        $post_fields = array(
            'categoryId' => $this->categoryId,
            'file' => new \CURLStringFile(
                $imageData->getStream()->getContents(),
                $imageData->getClientFilename(),
                $imageData->getClientMediaType(),
            )
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);

        // Set POST headers
        $headers = array(
            'Content-Type: multipart/form-data',
            'Authorization: ' . $token
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Return the response instead of printing it
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the request and close the curl session
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}
