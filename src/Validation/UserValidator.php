<?php 
namespace App\Validation;
use App\Validation\BaseValidator;

class UserValidator extends BaseValidator {

    protected $requiredFields = ['username', 'email', 'password'];

    public function validateCreate(array $data): array {
        $this->validateRequired($data);
        $errors = [];
        
        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'][] = "Email inválido";
        }if (!empty($data['password']) && !preg_match('/^(?=.*[A-Za-z])(?=.*\d).{6,}$/', $data['password'])) {
            $errors['password'][] = "Debe tener letras, números y al menos 6 caracteres";
        }if (!empty($data['username']) && strlen(trim($data['username'])) < 3) {
            $errors['username'][] = "El username debe tener al menos 3 caracteres";
        }if (!preg_match('/^[a-zA-Z0-9_]+$/', $data['username'])) {
                $errors['username'][] = "Solo letras, números y _";
        }if (!empty($errors)) {
                throw new \Exception(json_encode($errors), 400);
        }
        return $this->filterValidateAttributes($data);
    }

    public function validateUpdate(array $data): array{
        $errors = [];

        if (isset($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'][] = "Email inválido";
        }if (isset($data['password']) && !preg_match('/^(?=.*[A-Za-z])(?=.*\d).{6,}$/', $data['password'])) {
            $errors['password'][] = "Debe tener letras, números y al menos 6 caracteres";
        } if (isset($data['username']) && strlen(trim($data['username'])) < 3) {
            $errors['username'][] = "El username debe tener al menos 3 caracteres";
        }if (isset($data['username']) && !preg_match('/^[a-zA-Z0-9_]+$/', $data['username'])) {
            $errors['username'][] = "Solo letras, números y _";
        }if (!empty($errors)) {
               throw new \Exception(json_encode($errors), 400);
        }
        return $this->filterValidateAttributes($data);
    }

    public function validateLogin(array $data,string $user, string $pass){
        if(isset($data['password'],$data['username'] ) &&
        password_verify($pass, $data['password']) && $user === $data['username']){
            return true;
        }
        throw new \Exception("Credenciales inválidas", 401);
    }

}

