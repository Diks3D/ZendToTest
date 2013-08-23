<?php

namespace Dashboard\Form;

use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class UserForm extends Form
{
    public $inputFilter = null;

    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('message');
        $this->setAttribute('method', 'post');
        $this->addElements();
    }

    public function addElements()
    {
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'login',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Login: ',
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Email: ',
            ),
        ));
        $this->add(array(
            'name' => 'fullname',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Full Name: ',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
            ),
            'options' => array(
                'label' => 'Password: ',
            ),
        ));
         $this->add(array(
            'name' => 'confirm',
            'attributes' => array(
                'type' => 'password',
            ),
            'options' => array(
                'label' => 'Confirm: ',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Add',
                'id' => 'submitbutton',
            ),
        ));
        $this->add(array(
            'name' => 'reset',
            'attributes' => array(
                'type' => 'reset',
                'value' => 'Reset',
                'id' => 'resetbutton',
            ),
        ));
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                    'name' => 'id',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Int'),
                    ),
                )));

            $inputFilter->add($factory->createInput(array(
                    'name' => 'login',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name' => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min' => 4,
                                'max' => 50,
                            ),
                        ),
                        array('name' => 'Alnum'),
                    ),
                )));

            $inputFilter->add($factory->createInput(array(
                    'name' => 'email',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name' => 'EmailAddress',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min' => 3,
                                'max' => 100,
                            ),
                        ),
                    ),
                )));

            $inputFilter->add($factory->createInput(array(
                    'name' => 'fullname',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name' => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min' => 1,
                                'max' => 150,
                            ),
                        ),
                    ),
                )));
            
            $inputFilter->add($factory->createInput(array(
                    'name' => 'password',
                    'required' => true,
                    'validators' => array(
                        array(
                            'name' => 'StringLength',
                            'options' => array(
                                'min' => 8,
                            ),
                        ),
                    ),
                )));
            
            $inputFilter->add($factory->createInput(array(
                    'name' => 'confirm',
                    'required' => true,
                    'validators' => array(
                        array(
                            'name' => 'Identical',
                            'options' => array(
                                'token' => 'password'
                            ),
                        )
                    )
                )));
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}
