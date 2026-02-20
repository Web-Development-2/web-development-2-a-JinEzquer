<?php
$dir = __DIR__ . '/../config/jwt';
if (!is_dir($dir)) mkdir($dir, 0755, true);
$config = ['private_key_bits' => 2048, 'private_key_type' => OPENSSL_KEYTYPE_RSA, 'digest_alg' => 'sha256'];
$res = openssl_pkey_new($config);
$pass = getenv('JWT_PASSPHRASE') ?: 'fd322ac626738ff0ee7cceaf8f1ffd8725fe0330bcdc332981a4d3309e21a44d';
openssl_pkey_export($res, $privKey, $pass);
file_put_contents($dir . '/private.pem', $privKey);
$pubKey = openssl_pkey_get_details($res)['key'];
file_put_contents($dir . '/public.pem', $pubKey);
echo "JWT keys created in config/jwt\n";
