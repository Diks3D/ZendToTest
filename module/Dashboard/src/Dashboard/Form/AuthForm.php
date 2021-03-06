<?php

namespace Dashboard\Form;

use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class AuthForm extends Form
{
    public $inputFilter = null;

    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('auth');
        $this->setAttribute('method', 'post');
        $this->addElements();
    }

    public function addElements()
    {
        $this->add(array(
            'name' => 'login',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Login or Email: ',
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
                                'min' => 1,
                                'max' => 100,
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
            
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}
