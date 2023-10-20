<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$privateKey = <<<EOD
-----BEGIN PRIVATE KEY-----
MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCUVadvcrQqFI5S
dgjfl859FEmkJz+zE1IT4rXFmQ0roaGlmI5oasfgw9QZbKhs3ek5TpjbQc3auHJY
odLsfADMZP5zbPKKZoBzJ77kB79hjVTj6HZlGHFJK1zndRoGbV41Pj6njLVA0UI6
c5hV46QGzytg3ZakDQu+abMZITsOfiMN0O/QjJyXGphZVpt3WgsuzIzQOEYGd/HH
Gkc5XqDYnfU49iCzeJfHH3NHnUYBe2Jo071NrkzWafCwJg9yJb7MfDyMiMNii2Mj
j2Dn601ZvjZlWFWP5zaDcIg24bSa2z63V1zqZmuFB6UZPZwF0K394oIGgLGzk1Tx
qavBsVk/AgMBAAECggEADMWWkz3U7b3zsShGRFDoWmmu8N+LmF95/4n+LQOBbaJ5
mMNaw6UqDPF054mCXk6kdabi+hdKN7e46hETkwFsT4JZ9wCdnjVhgEjJorhYuKK4
I/V7ODd+DZbvurgg+QZdXbKR0iWx4jZXqvu9VUEypClzVTWkclSd5b5pHtP3J0dV
1eo6jkAqSw90YsYeebSzy13N8p9qc+WTFmJfuVr68DtVl8hBATIGPj5B81k9o7+g
WFBsFnEkdrBnRWPdvY0BPLyeeiI4UPvQVjjtMvXIMY3TX/A8K0HX94yTAJaQU2P3
FGo3hOLcPqraeEclhCx51rToNRMhnzoY2RBEyuw0zQKBgQDIIsH2x2LWRa7CiXKH
B3Vo3sJKYjes6M45yY4vPGfMcFi7WJvxWtPz39QnTitcaZV91itBTX0CpFrHU7gP
apNGcGddFn0eyLFE3bA5l0mwB2dK+VoI45oy9A9W6dEHSpFB4CwMVOOcJ+HnX7E7
ViInQt4TE9Xzg8DK+IL1qpoLhQKBgQC9vU17kOJuwavbwouQhFh+lyI4yt4nQpNY
hj+IEK6fNk0VI4KnmDOMyrZz+8e/dncjuCJvowNIvH72pll1O25SccIse7j6fqQQ
UDQXnY9Y5H1F+HP6NAgXQRyWXUnb2t9zllVdnWkM8tzQhgk83o/GNrkFkW/kg3Jy
mhBMfyni8wKBgG+Y8g9pnvNcZ9aSTgp9Xjrb+/r+SY1hQ511hpNQW5DkFJZjEpHC
0+1pIiPIsuUU+wbwJa6ERvDyNKxxQnFWPElK5FhD8gD4Z+C+vUVf1vcRKcfkww+x
2ooPDX6pYqVuLxFMr0MxErpAgvdBpNIxdVnvL2Xz6ZmgHiEP8faK6tsBAoGBAKb6
UJT89Xi5MhBNTluZTPPi93f5eLYeTeOrCYAqBjMRK5b90D7DoCI4R4ccvjYOAF1L
7+pFEF/TmvxfevzDl5wwhsx0+V5hUusUWjOqMnvtYR3Rv+ciITit0YW2hYhZPyrO
00N2gvulQ5SzUK/jwa2TfRKcYlc9ItweH1fi1S7nAoGAOd/wtAWub1OL9E2krK3b
UC6dSVaKXziw52Z1r7wm5UVZ6w46uPAEsXSAqZGSXG2bLIttm31SaruY8LwwGcjM
PqKgilMVDnppGHgHP/o4ycprPfzHYt+JHgLyzvBPTpwAf4nNw3Hs8Mzt+pdD1dUU
+K0+sjYMtmD4QjYjPhBYz3w=
-----END PRIVATE KEY-----
EOD;

// NOTE: Before you proceed with the TOKEN, verify your users session or access.

$payload = array(
  "sub" => "bgordon@healthyhearing.com", // unique user id string
  "name" => "Brian Gordon", // full name of user

  // Optional custom user root path
  // "https://claims.tiny.cloud/drive/root" => "/johndoe",

  "exp" => time() + 60 * 10 // 10 minute expiration
);

try {
  $token = JWT::encode($payload, $privateKey, 'RS256');
  http_response_code(200);
  header('Content-Type: application/json');
  echo json_encode(array("token" => $token));
} catch (Exception $e) {
  http_response_code(500);
  header('Content-Type: application/json');
  echo $e->getMessage();
}
?>