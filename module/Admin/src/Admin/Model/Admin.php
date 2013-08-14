<?php
namespace Admin\Model;
 
use Zend\InputFilter\Factory as InputFactory,
    Zend\InputFilter\InputFilter,
    Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilterInterface;
 
class Admin implements InputFilterAwareInterface
{
    public $id;
    public $login;
    public $email;
    public $fullName;
    public $passHash;
    public $created;
    public $lastLogin;
    
    protected $inputFilter;
 
    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->login = (isset($data['login'])) ? $data['login'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->fullName = (isset($data['full_name'])) ? $data['full_name'] : null;
        $this->passHash = (isset($data['pass_hash'])) ? $data['pass_hash'] : null;
        $this->created = (isset($data['created'])) ? \DateTime::createFromFormat('Y-m-d H:i:s', $data['created']) : null;
        $this->lastLogin = (isset($data['last_login'])) ? \DateTime::createFromFormat('Y-m-d H:i:s', $data['last_login']) : null;
    }
    
    public function getArrayCopy()
    {
        var_dump($this); exit;
        return get_object_vars($this);
    }
 
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
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));
 
            $inputFilter->add($factory->createInput(array(
                'name'     => 'login',
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
                            'max'      => 50,
                        ),
                    ),
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(
                    array(
                        'name' => 'password',
                        'required' => true,
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'min' => 8,
                                    'max' => 50,
                                ),
                            ),
                        ),
            )));
 
            $inputFilter->add($factory->createInput(array(
                'name'     => 'title',
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
            )));
 
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}
