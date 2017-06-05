<?php

namespace Core\Form;

/**
 * Class Form
 *
 * @author Adrien PAYEN <adrien.payen2@gmail.com>
 */
class Form extends FormValidator
{
    private $entity;
    private $form;
    private $validator;

    public function __construct($entity, $form)
    {
        $this->entity = $entity;
        $this->form = $form;
        $this->validator = $validator = new FormValidator();
    }

    public function getForm()
    {
        $entity = '\\'.$this->entity;
        $form = $this->form;

        return $entity::$form();
    }

    /**
     *
     */
    public function isValid()
    {
        foreach ($this->getForm()['data'] as $key=>$data) {
            $this->validator->distributor($key, $this->getForm()['data']);
        }

        if($this->getErrors()){
            return false;
        }
        return true;
    }

    /**
     * @return array|bool
     */
    public function getErrors()
    {
        if ($this->validator->errors) {
            return $this->validator->errors;
        }

        return false;
    }
    
    public function clean()
    {
        
    }
}