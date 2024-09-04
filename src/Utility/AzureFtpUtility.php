<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\Core\Configure;
use Firebase\JWT\JWT;

class AzureFtpUtility
{
	private $accountName;
	private $containerName;
	private $decodedAccountKey;
	private $version;

    public function __construct()
    {
		$this->accountName = Configure::read('AzureFtp.accountName');
		$this->containerName = Configure::read('AzureFtp.containerName');
		$this->decodedAccountKey = base64_decode(Configure::read('AzureFtp.accountKey'));
		$this->version = "2020-04-08";
    }

	public function retrieveFile($blobName)
	{
		$date = gmdate("D, d M Y H:i:s T", time());
		$method = "GET";
		$url = "https://$this->accountName.blob.core.windows.net/$this->containerName/$blobName";

		// Create the string to sign
		$stringToSign = "$method\n\n\n\n\n\n\n\n\n\n\n\nx-ms-date:$date\nx-ms-version:$this->version\n/$this->accountName/$this->containerName/$blobName";

		// Create the signature
		$signature = base64_encode(hash_hmac('sha256', $stringToSign, $this->decodedAccountKey, true));

		// Create the authorization header
		$authHeader = "SharedKey $this->accountName:$signature";

		// Initialize cURL
		$ch = curl_init($url);

		// Set cURL options
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
		    "x-ms-date: $date",
		    "x-ms-version: $this->version",
		    "Authorization: $authHeader"
		]);

		// Execute the request
		$response = curl_exec($ch);

		// Close cURL
		curl_close($ch);

		if ($response === false) {
		    echo "cURL Error: " . curl_error($ch);
		} else {
	        // Check HTTP status code
	        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	        if ($httpCode == 200) {
	            // Add Unix timestamp to the filename
	            $timestamp = time();
	            $pathInfo = pathinfo($blobName);
	            $filename = $pathInfo['filename'];
	            $extension = isset($pathInfo['extension']) ? '.' . $pathInfo['extension'] : '';
	            $filePath = './' . $filename . '_' . $timestamp . $extension;

	            // Save the blob content to a file
	            file_put_contents($filePath, $response);
	            echo "Blob downloaded successfully to $filePath\n";

	            return true;
	        } else {
	            echo "Failed to download the blob. HTTP Code: $httpCode\n";

	            return false;
	        }
	}
}