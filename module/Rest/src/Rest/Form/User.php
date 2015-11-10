<?php
namespace Rest\Form;

class User
{
    public $email;
    public $password;
    public $age;

    //Copy data from array into instance
    public function exchangeArray($data)
    {
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->password  = (isset($data['password']))  ? $data['password']  : null;
        $this->age     = (isset($data['age']))     ? $data['age']     : null;
    }

}