<?php
namespace App\Validation;
use App\Validation\BaseValidator;

class  TaskValidator extends BaseValidator {

    protected $requiredFields = ['title', 'description'];

    public function validateCreate(array $data): array {
        $this->validateRequired($data);
        $errors = [];

        if (!empty($data['title']) && strlen(trim($data['title'])) < 3) {
             $errors['title'][] = "El título debe tener al menos 3 caracteres";
        }if (!empty($data['description']) && strlen(trim($data['description'])) < 5) {
             $errors['description'][] = "La descripción debe tener al menos 5 caracteres";
        }if (isset($data['status'])) {
            $validStatus = ['pending', 'in_progress', 'done'];
        }if (!in_array($data['status'], $validStatus)) {
            $errors['status'][] = "Estado inválido";
        }if (isset($data['priority'])) {
            $validPriority = ['low', 'medium', 'high'];
        }if (!in_array($data['priority'], $validPriority)) {
            $errors['priority'][] = "Prioridad inválida";
        }if (isset($data['start_date']) && !strtotime($data['start_date'])) {
            $errors['start_date'][] = "Fecha de inicio inválida";
        }if (isset($data['due_date']) && !strtotime($data['due_date'])) {
            $errors['due_date'][] = "Fecha de vencimiento inválida";
        }if (isset($data['start_date'], $data['due_date']) && strtotime($data['due_date']) < strtotime($data['start_date'])) {
            $errors['due_date'][] = "Debe ser posterior a start_date";
        }if (!empty($errors)) {
          throw new \Exception(json_encode($errors), 400);
        }

        return $this->filterValidateAttributes($data);
    }

    public function updateTask(){
        
    }

}