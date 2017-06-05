<?php

namespace Core\Form;

use Core\Basics\Request;
use Core\Database\BaseSql;

/**
 * Class FormValidator
 *
 * @author Adrien PAYEN <adrien.payen2@gmail.com>
 */
class FormValidator
{
    /** @var array */
    protected $errors = [];

    /**
     * @param $key
     * @param $datas
     * @return bool
     */
    public function distributor($key, $datas)
    {
        $status = true;

        if($datas[$key]['rules']['type']) {
           FormValidator::checkType($key, $datas[$key]['rules']['type']);
        } elseif ($datas[$key]['type']) {
            FormValidator::checkType($key, $datas[$key]['type']);
        }

        if($datas[$key]['required'] === true) {
            FormValidator::checkNotNull($key, $datas[$key]['rules']);
        }

        if($datas[$key]['rules']['min'] or $datas[$key]['rules']['max']) {
            FormValidator::checkSize($key, $datas[$key]['rules']);
        }

        if($datas[$key]['rules']['unique']) {
            FormValidator::isUnique($key);
        }

        return $status;
    }

    /**
     * @param $key
     * @param $rule
     * @return bool
     */
    public function checkSize($key, $rule)
    {
        if($rule['min'] && $rule['max']){
            if(strlen(Request::get($key)) <= $rule['min'] || strlen(Request::get($key)) >= $rule['max']) {
                $this->addErrors(FormError::getError('min_max'), [$key, $rule['min'], $rule['max']]);
            }
        } elseif ($rule['min']) {
            if(strlen(Request::get($key)) <= $rule['min']) {
                $this->addErrors(FormError::getError('max'), [$key, $rule['min']]);
            }
        } elseif ($rule['max']) {
            if(strlen(Request::get($key)) >= $rule['max']) {
                $this->addErrors(FormError::getError('min'), [$key, $rule['max']]);
            }
        }

        return false;
    }

    /**
     * @param $key
     * @param $rule
     * @return bool
     */
    public function checkType($key, $rule)
    {
        if($rule === "email" && !filter_var(Request::get($key), FILTER_VALIDATE_EMAIL)) {
            $this->addErrors(FormError::getError('email'));
        }

        if($rule === "string" && !ctype_alnum(Request::get($key))) {
            $this->addErrors(FormError::getError('string'));
        }

        if($rule === "int" && !is_int(Request::get($key))) {
            $this->addErrors(FormError::getError('int'));
        }

        if ($rule === "date" && !\DateTime::createFromFormat('Y-m-d', Request::get($key))) {
            $this->addErrors(FormError::getError('date'));
        }

        if ($rule === "repeated" && Request::get($key."_first") !== Request::get($key."_second")) {
            $this->addErrors(FormError::getError('repeated'), [$key]);
        }

        return false;
    }

    /**
     * @param $key
     * @param $rules
     */
    public function checkNotNull($key, $rules)
    {
        if ($key === "password" &&
            $rules['type'] === "repeated" &&
            (!Request::get($key."_first") or !Request::get($key."_second"))
        ) {
            $this->addErrors(FormError::getError('required'), [$key]);
        } elseif (!Request::get($key) && $rules['type'] !== "repeated") {
            $this->addErrors(FormError::getError('required'), [$key]);
        }
    }

    /**
     * @param $key
     */
    public function isUnique($key)
    {
        $basesql = BaseSql::getInstance();

        if (!$basesql->isUnique(Request::get($key), $key, "user")) {
            $this->addErrors(FormError::getError('unique'), [$key]);
        }
    }

    /**
     * @param $error
     * @param array $data
     */
    public function addErrors($error, $data = [])
    {
        $this->errors[] = vsprintf($error, $data);
    }

    // TODO: dateinterval, unique, image, file, choice, equalTo, regex
}