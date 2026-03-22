<?php 
namespace App\Validation;

class BaseValidator{
    protected $validAttributes = [
        'username',
        'email', 
        'password',
        'name',                 
        'user_id',             
        'title',
        'description', 
        'status',
        'priority',
        'category_id',             
        'start_date',              
        'due_date'               
    ];

    protected  $requiredFields = [];

    protected function filterValidateAttributes(array $data): array {
        return array_intersect_key(
            $data, 
            array_flip($this->validAttributes)
        );
    }

    protected function validateRequired(array $data){
        $errors = [];
        foreach($this->requiredFields as $field){
         if (!isset($data[$field]) || empty(trim($data[$field]))) {
                $errors[$field][] = "El campo $field es requerido";
            }
        }
        if(!empty($errors)){
             throw new \Exception(json_encode($errors), 400);
        }
    }



}