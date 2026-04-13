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
        }if (!empty($data['username']) && !preg_match('/^[a-zA-Z0-9_]+$/', $data['username'])) {
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

    public function validateLogin(array $data){
          $errors = [];
        if (empty($data['username'])) {
            $errors['username'][] = "Username es requerido";
        }
        if (empty($data['password'])) {
            $errors['password'][] = "Password es requerido";
        }
        if (!empty($errors)) {
            throw new \Exception(json_encode($errors), 400);
        }
    }

    public function validateId($id): void {
        parent::validateId($id);  
    }
    
    public function bValidate($data){
       return $this->filterValidateAttributes($data);
    }

}

