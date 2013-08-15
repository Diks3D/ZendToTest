<?php

namespace Audio\Form;
 
use Zend\Form\Element;
use Zend\Form\Form;
 
class UploadForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('audiofile', $options);
        $this->setAttribute('method', 'post');
        $this->addElements();
    }
    
    public function addElements()
    {
        $file = new Element\File('files');
        $file->setLabel('Avatar Image Upload')
            ->setAttribute('multiple', true);   
        $this->add($file);
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Upload',
                'class' => 'btn btn-success',
                'id' => 'submitbutton',
            ),
        ));
        $this->add(array(
            'name' => 'reset',
            'attributes' => array(
                'type'  => 'reset',
                'value' => 'Clear',
                'class' => 'btn btn-warning',
                'id' => 'resetbutton',
            ),
        ));
    }
}
