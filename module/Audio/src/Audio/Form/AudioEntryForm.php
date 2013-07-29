<?php

namespace Audio\Form;
 
use Zend\Form\Form;
 
class AudioEntryForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('audiotrack');
        $this->setAttribute('method', 'post');
        $this->addElements();
    }
    
    public function addElements(){
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'filename',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Filename: ',
            ),
        ));
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Title: ',
            ),
        ));
        $this->add(array(
            'name' => 'artist',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Artist: ',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Approve',
                'id' => 'submitbutton',
            ),
        ));
        $this->add(array(
            'name' => 'reset',
            'attributes' => array(
                'type'  => 'reset',
                'value' => 'Reset',
                'id' => 'resetbutton',
            ),
        ));
    }
}

