<?php 
namespace App\Validation;
use App\Validation\BaseValidator;

class CategoryValidator extends BaseValidator {
    protected $requiredFields = ['name'];

      public function validateCreate(array $data): array {
        $this->validateRequired($data);
        $errors = [];
        
        if (!empty($data['name']) && strlen($data['name']) < 2) {
            $errors['name'][] = "El nombre debe tener al menos 2 caracteres";
        }if (!empty($errors)) {
            throw new \Exception(json_encode($errors), 400);
        }
        return $this->filterValidateAttributes($data);
    }
}