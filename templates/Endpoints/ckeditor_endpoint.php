<?php
    require WWW_ROOT . '../vendor/autoload.php';

    use \Firebase\JWT\JWT;

    $accessKey = 'GruAKE1qtAen5lwdhiJbsn3z0ieiQ6JKfdDa5fTH0zK2sapn9fcfr0lWOZi6';
    $environmentId = '0KVvJvNAVP0yopdHKVXR';

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

    echo $jwt;
?>