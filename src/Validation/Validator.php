<?php 
namespace App\Validation;

class Validaotr{
    private $validAttributes = [
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

    public function filterValidAttributes(array $data): array {
        return array_intersect_key(
            $data, 
            array_flip($this->validAttributes)
        );
    }

}