<?php
use \Firebase\JWT\JWT;

function generate_jwt($data, $secret_key, $expire_seconds = 3600)
{
    $issuedAt = time();
    $payload = array(
        "iat" => $issuedAt,
        "exp" => $issuedAt + $expire_seconds,
        "data" => $data
    );

    return JWT::encode($payload, $secret_key, 'HS256');
}

function verify_jwt($token, $secret_key)
{
    try {
        $decoded = JWT::decode($token, new \Firebase\JWT\Key($secret_key, 'HS256'));
        return (array) $decoded->data;
    } catch (Exception $e) {
        return false;
    }
}
