<?php
namespace Rest\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilter;

class SignUpForm extends Form implements InputFilterAwareInterface
{
    //Standart Form with Validating
    protected $inputFilter;

    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('rest');
        //создаем форму, назначаем ей поля с именами, типами и значениями
        $this->add(array(
            'name' => 'email',
            'type' => 'Text',
            'options' => array(
                //указываем саму надпись,которая будет перед полем
                'label' => 'email ',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'type' => 'Text',
            'options' => array(
                'label' => 'Password ',
            ),
        ));
        $this->add(array(
            'name' => 'age',
            'type' => 'Text',
            'options' => array(
                'label' => 'Age ',
            ),


        ));

    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name'     => 'email',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'password',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            ));
            $inputFilter->add(array(
                'name'     => 'age',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}