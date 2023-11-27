<?php
    require WWW_ROOT . '../vendor/autoload.php';

    use \Firebase\JWT\JWT;
    use \GuzzleHttp\Client;

    $accessKey = 'GruAKE1qtAen5lwdhiJbsn3z0ieiQ6JKfdDa5fTH0zK2sapn9fcfr0lWOZi6';
    $environmentId = '0KVvJvNAVP0yopdHKVXR';

    if ($userWorkspace === null) {
        $client = new Client();

        $response = $client->post('https://api.ckbox.io/superadmin/workspaces', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'name' => 'Example workspace', // You can customize this as needed
            ],
        ]);

        $workspaceData = json_decode($response->getBody(), true);

        // Assign the new workspace ID to the user
        $userWorkspace = $workspaceData['id'];
        // Optionally save this ID back to the user entity or wherever it's stored
    } else {
        $userWorkspace = [$userWorkspace];
    }

    $payload = [
        'aud' => $environmentId,
        'iat' => time(),
        'sub' => 'finance@healthyhearing.com',
        'auth' => [
            'ckbox' => [
                'role' => 'user'/*$userRole*/,
                'workspaces' => $userWorkspace,
            ]
        ]
    ];

    $jwt = JWT::encode($payload, $accessKey, 'HS256');

    echo $jwt;
?>