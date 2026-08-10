<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function generate_jwt_token($user)
{
    $key = 'your_secret_key'; // Bạn nên đưa vào .env hoặc config
    $payload = [
        'iss' => 'http://localhost', // issuer
        'iat' => time(),             // issued at
        'exp' => time() + (3600 * 24 * 7), // expires in 7 days
        'id' => $user->id,
        'email' => $user->email
    ];
    return JWT::encode($payload, $key, 'HS256');
}

function decode_jwt_token($token) {
    if (!$token) {
        throw new Exception("JWT token is missing.");
    }
    // var_dump($token);
    // die();
    // try{
      $secret_key = 'your_secret_key';
      return JWT::decode($token, new Key($secret_key, 'HS256'));
  //   }
  //   catch (Exception $e) {
  // echo (' exception token ' . $token  );
}




function verify_jwt_token($token)
{
    $key = 'your_secret_key';
    return JWT::decode($token, new Key($key, 'HS256'));
}

function get_bearer_token($headers)
{
    if (isset($headers['Authorization'])) {
        $matches = [];
        if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
            return $matches[1];
        }
    }
    return null;
}
