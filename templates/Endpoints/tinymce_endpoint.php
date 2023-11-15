<?php
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$privateKey = <<<EOD
-----BEGIN PRIVATE KEY-----
MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQC9DqSN5eVONAkv
9Hy/jV1l00PTyG7vZOuG7ICjUPgX0EvIzYdg3/2jLtLEPhLIGs+I9fLxItohDiMh
eRP8ZAqSgeQtyFDEkg+RLxRSe34BCLxP/fZ6xviYIqMymdTN2iUp0yKkhGtLbxot
E8UmRrANEHTil7rWhYoZLRIxgkRvFy0mDbSw8TaOLatgpJ4J+sGlN08fXl3/1yYO
noLeAVrkPI3Fg8svoxgopazXI1q3VC2+vhQjSQUZaM+J7GCu2WGL1IgCNc+42Wps
p31VIr2ePUHDABmf//4B0Dpw5elUDr1Abem/pBKJ8wSy3kpHHPE9hHbsDLKeG3wb
BuX/Lx+NAgMBAAECggEALJPBC58/KekdmHPUnULrGIkPp2ZNd/9rBImLzFZZZR4N
XHfPubEe6ETwV+rN+WZO9HuPkLl3xs8DTA91Pa/mCUT8xSnEF5Fb/87iww8QtxQ0
+MSIQ0tajt6t7c61TWNoG1xIARQjC2qTOLk+ZWfJ946fjNUbbh0XIpgMv+U4Fxwu
dYv8O1bsORwSvIgQfTsSBB6effypp5xhLCcqqALbBBLuw25d5C2951dFYxZDut7v
O+8z0sB0b305VSZVhfivy8MbGvbyk2z1QmnVYOlQQQq7DjsqNl5jhSZArQPJMml5
jm3AlClC5j4HWxzxB1vsZPYGJYno1k5K4Tpld4UrMQKBgQD7L382ajPeuX3Qql2L
z0k01Z80XjJg2bkeaKw4ypXr+xH9uXGqFoQJ55EJHJ8ynfQtNLu2H8gzldOSzQ64
bK1RRBWuQV8ECM8mB/VUqIC8irpoki5UQoVuHSy9AKHzx9VuTxCgebv3E7EzFJ2o
GS3jKfntxwAok5sazu5KcOl63QKBgQDArkxL8yZutoKSbykOZ+DIFDtK0Rb9Affl
pyiRpid9KMZSGTbbNxaQXO88kx04AUavwhvqwIpYY1RITrhHsu79jGMHMcKtz9S2
Y/UJpSdpnCLp37nritpjs3TBGKuHvaflMgsvnv8SXvYi/bmlcTUhvAu8seS2AVrE
P9g8Gac0cQKBgGGlfDmmHZX23A8zO3xvT5EnfmV4PPNjkFBe9px5PMDo8HyHC8XI
TPoguEQniUe/Gb49Ir/RKR3Mn9wQtSlCrjnKUvdT2GEUH5s0Os33V1x0PbULJtGA
rqg41TyAM3U2eSURvW/1AvoxAJDP8d34M9t8ZPlnhAtCHmjUitQLguhNAoGADRSI
B2vlQwTOzmQPdHPm1Y5SDB0vo1Nb4dI8Nc8CxUNcWzxs9erCdGBquUD/bcrgYpQZ
0xDpE2EC2rnFVtC12q6KFnXxUl1Wgl88xj/Y8hlwYVIXy/6sHrKTDXzAQEHGwQ9p
pPz1MekSaoOw86NAyR576X5mGVj0MXhoFIRlTnECgYANvOupFDIb8214Ur65TI/k
W3C/JFY2kN3b4iiXF+A4lJ3GlC/2u+IhxrUHewIOj/MG5ie7PnPoB0z0qQnt1a1I
UtNrvO1lsKuwAR/od1zoJmRjCxyxX7f5AmU1JgNTDik/ZKi7iNUwK+aCjIWPIE20
uIz5rEJo9laIr8QaIAD0fw==
-----END PRIVATE KEY-----
EOD;

// NOTE: Before you proceed with the TOKEN, verify your users session or access.

$payload = array(
  "sub" => "it@healthyhearing.com", // unique user id string
  "name" => "HH User", // full name of user

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