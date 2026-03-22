<?php
namespace App\Validation;
use App\Validation\BaseValidator;

class  TaskValidator extends BaseValidator {

    protected $requiredFields = ['title', 'description'];

    private function validateFields(array $data): void {
        $errors = []; 

        if (isset($data['status'])) {
            $validStatus = ['pending', 'in_progress', 'done'];
            if (!in_array($data['status'], $validStatus)) {
                $errors['status'][] = "Estado inválido";
            }
        }if (isset($data['priority'])) {
            $validPriority = ['low', 'medium', 'high'];
            if (!in_array($data['priority'], $validPriority)) {
                $errors['priority'][] = "Prioridad inválida";
            }
        }if (isset($data['start_date']) && !strtotime($data['start_date'])) {
            $errors['start_date'][] = "Fecha de inicio inválida";
        }if (isset($data['due_date']) && !strtotime($data['due_date'])) {
            $errors['due_date'][] = "Fecha de vencimiento inválida";
        }if (isset($data['start_date'], $data['due_date']) && strtotime($data['due_date']) < strtotime($data['start_date'])) {
            $errors['due_date'][] = "Debe ser posterior a start_date";
        }if (!empty($errors)) {
             throw new \Exception(json_encode($errors), 400);
        }
    }

    public function validateCreate(array $data): array {
        $errors = []; 
        $this->validateRequired($data);
        if (strlen(trim($data['title'])) < 3) {
                $errors['title'][] = "El título debe tener al menos 3 caracteres";
        }if ( strlen(trim($data['description'])) < 5) {
            $errors['description'][] = "La descripción debe tener al menos 5 caracteres";
        }if (!empty($errors)) {
             throw new \Exception(json_encode($errors), 400);
        }
        $this->validateFields($data);
        return $this->filterValidateAttributes($data);
        
    }

    public function updateTask(array $data){
        if (( isset($data['title'])) && strlen(trim($data['title'])) < 3) {
            $errors['title'][] = "El título debe tener al menos 3 caracteres";
        }if (( isset($data['description'])) && strlen(trim($data['description'])) < 5) {
            $errors['description'][] = "La descripción debe tener al menos 5 caracteres";

        }
        if (!empty($errors)) {
        throw new \Exception(json_encode($errors), 400);
        }
        $this->validateFields($data);
        return $this->filterValidateAttributes($data);
    }
    

}