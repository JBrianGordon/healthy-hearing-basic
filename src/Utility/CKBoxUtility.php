<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\Core\Configure;
use Firebase\JWT\JWT;
use Cake\Event\Event;
use Cake\Event\EventManager;

class CKBoxUtility
{
    private $apiKey;
    private $apiUrl;
    private $envId;
    private $apiSecret;
    private $userId;
    private $role;

    public function __construct($categoryId)
    {
        $this->apiUrl = 'https://api.ckbox.io/assets';
        $this->envId = Configure::read('CK.envId');
        $this->apiSecret = Configure::read('CK.apiSecret');
        $this->userId = Configure::read('CK.userId');
        $this->role = Configure::read('CK.role');
        $this->categoryId = $categoryId;
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

    public function uploadImage($imageData, $filename)
    {
        $contents = stream_get_contents($imageData);

        fclose($imageData);

        $imageInfo = getimagesizefromstring($contents);

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
                $contents,
                $filename,
                $imageInfo['mime'],
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

        $responseData = json_decode($response, true);

        // Dispatch the event
        $event = new Event(
            'CkBoxUtility.afterUploadImage',
            $this, [
                'response' => $responseData,
            ]
        );
        EventManager::instance()->dispatch($event);

        return $responseData;
    }

    public function deleteImage($imageId)
    {
        // Authorization token
        $token = $this->generateToken($this->userId, $this->role);

        // Initialize cURL
        $ch = curl_init();

        // Set URL
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . '/delete?workspaceId=' . $this->envId);

        // Set request method
        curl_setopt($ch, CURLOPT_POST, true);

        // Build POST fields
        $post_fields = json_encode([$imageId]);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);

        // Set POST headers
        $headers = array(
            'Content-Type: application/json',
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

    public function copyImage($imageId)
    {
        // Authorization token
        $token = $this->generateToken($this->userId, $this->role);

        // Initialize cURL
        $ch = curl_init();

        // Set URL
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . '/copy');

        // Set request method
        curl_setopt($ch, CURLOPT_POST, true);

        // Build POST fields
        $post_fields = [
            'target' => [
                'categoryId' => $this->categoryId,
            ],
            'assetsActions' => [
                [
                    'assetId' => $imageId,
                    'action' => 'rename',
                ]
            ]
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_fields));

        // Set POST headers
        $headers = array(
            'Content-Type: application/json',
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

    public function recentItems()
    {
        // Authorization token
        $token = $this->generateToken($this->userId, $this->role);

        // Initialize cURL
        $ch = curl_init();

        // Set URL
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . '/recent?limit=5');

        $headers = array(
            'Content-Type: application/json',
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

    public function renameItem($assetId, $newFilename)
    {
         // Authorization token
        $token = $this->generateToken($this->userId, $this->role);

        // Initialize cURL
        $ch = curl_init();

        // Set URL
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . '/' . $assetId);

        // Build POST fields
        $post_fields = [
            'name' => $newFilename,
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_fields));

        // Set request method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');

        $headers = array(
            'Content-Type: application/json',
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
