<?php
namespace Dashboard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *  @ORM\Entity
 *  @ORM\Table(name="ad_admin")
 */
class Admin
{
    /**
     * @ORM\Id
     * @ORM\OneToMany(targetEntity="Message", cascade={"ALL"})
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", unique=true, length=100)
     */
    protected $login;
    
    /**
     * @ORM\Column(type="string", unique=true, length=150)
     */
    protected $email;
    
    /** 
     * @ORM\Column(name="pass_hash", type="string", length=32)
     */
    protected $passHash;
    
    /** 
     * @ORM\Column(name="full_name", type="string")
     */
    protected $fullName;
    
    /** @ORM\Column(name="info_xml", type="text")
     * @var string
     */
    protected $info;
    
    /** Magic getter and setter */
    public function __get($name)
    {
        if(method_exists($this,$MethodName='get' . ucfirst($name))){
                return $this->$MethodName();
        } else {
            return null;
        }
    }
    
    public function __set($name, $value)
    {
        if(method_exists($this,$MethodName='set' . ucfirst($name))){
                return $this->$MethodName($value);
        }
        throw new \Exception('class ' . __CLASS__ . ' has no ' . $MethodName . ' method!');
    }
    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return Admin
     */
    public function setLogin($login)
    {
        $this->login = $login;
    
        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Admin
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set passHash
     *
     * @param string $passHash
     * @return Admin
     */
    public function setPassHash($passHash)
    {
        $this->passHash = $passHash;
    
        return $this;
    }

    /**
     * Get passHash
     *
     * @return string 
     */
    public function getPassHash()
    {
        return $this->passHash;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     * @return Admin
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    
        return $this;
    }

    /**
     * Get fullName
     *
     * @return string 
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set info
     *
     * @param \stdClass $info
     * @return Admin
     */
    public function setInfo($info)
    {
        $this->info = $info;
    
        return $this;
    }

    /**
     * Get info
     *
     * @return \stdClass 
     */
    public function getInfo()
    {
        return $this->info;
    }
}