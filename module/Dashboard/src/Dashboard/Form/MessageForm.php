<?php
namespace Dashboard\Form;

use Zend\Form\Form;

class MessageForm extends Form
{

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
            'name' => 'message',
            'attributes' => array(
                'type' => 'textarea',
                'cols' => 100,  
                'rows' => 6,
            ),
            'options' => array(
                'label' => 'Message: ',
            ),
        ));
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Title: ',
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

}