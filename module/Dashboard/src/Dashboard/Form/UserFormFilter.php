<?php

namespace Dashboard\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class UserFormFilter
{
    public $inputFilter = null;

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new Exception("Not used");
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
                                'min' => 1,
                                'max' => 100,
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