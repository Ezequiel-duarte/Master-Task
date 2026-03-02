<?php
require_once 'config.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;


class JWT {
    private const EXPIRATION_TIME = 86400;

public static function generate($userID){
    if empty($userID){
        throw new InvalidArgumentException('User ID cannot be empty');
    }

    $payload = [
            'user_id' => $userID,
            'iat' => time(), 
            'exp' => time() + self::EXPIRATION_TIME, 
            'jti' => uniqid('MT_JWT_', true) // JWT Id
         ];
    return JWT::encode($payload, JWT_KEY, 'HS256');
}

public static function validate($token){
     if (empty($token)) {
            return false;
        }

        try {
            $decoded = JWT::decode($token, new Key(JWT_KEY, 'HS256'));
            return (array) $decoded;   
        } catch (ExpiredException $e) {
            error_log('Token expirado: ' . $e->getMessage());
            return false;
        } catch (SignatureInvalidException $e) {
            error_log('Firma inválida: ' . $e->getMessage());
            return false;
        } catch (BeforeValidException $e) {
            error_log('Token no válido aún: ' . $e->getMessage());
            return false;
        } catch (UnexpectedValueException $e) {
            error_log('Error inesperado con el token: ' . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log('Error validando token: ' . $e->getMessage());
            return false;
        }
}
}