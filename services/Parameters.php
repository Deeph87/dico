<?php
/**
 * Created by PhpStorm.
 * User: jhaudry
 * Date: 21/03/2018
 * Time: 14:08
 */

namespace Dico\Services;


class Parameters
{
    // Params for users ressources with the requirement status
    const USER_VALID_PARAMETERS = [
        'email',
        'firstname',
        'lastname',
        'gender',
        'age',
        'date_signin',
        'password',
        'date_last_login'
    ];

    const USER_REQUIRED_PARAMETERS = [
        'email',
        'firstname',
        'lastname',
        'password'
    ];

    const WOMEN = 0;
    const MAN = 1;

    private $parameters;

    public function __construct($parameters){
        $this->parameters = $parameters;
    }

    public function areValid($compareArray){
        $error = [
            'state' => false,
            'status' => 406
        ];
        $success = [
            'state' => true,
            'status' => 201
        ];

        foreach (self::USER_REQUIRED_PARAMETERS as $requiredParam){
            if(empty($this->parameters[$requiredParam])){
                return $error;
                break;
            }
        }
        foreach ($this->parameters as $param => $value){
            if(!in_array($param, $compareArray)){
                return $error;
                break;
            }
        }

        if(!filter_var($this->parameters['email'], FILTER_VALIDATE_EMAIL))
            return $error;

        if(!empty($this->parameters['age']) && !filter_var($this->parameters['age'], FILTER_VALIDATE_INT))
            return $error;

        if(!empty($this->parameters['gender']) && !filter_var($this->parameters['gender'], FILTER_VALIDATE_INT))
            return $error;

        return $success;
    }
}