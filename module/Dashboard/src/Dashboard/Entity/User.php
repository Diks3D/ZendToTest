<?php
namespace Dashboard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *  @ORM\Entity
 *  @ORM\Table(name="ad_user")
 *  @ORM\HasLifecycleCallbacks()
 */
class User
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

   /**
     *  @ORM\Column(type="datetime")
     *  @var \DateTime
     */
    protected $created;
    
    /**
     *  @ORM\Column(name="last_login", type="datetime")
     *  @var \DateTime
     */
    protected $lastLogin;

    /**
     * @ORM\prePersist
     */
    public function setCreatedValue()
    {
        $this->created = new \DateTime();
    }
    
    /**
     * @ORM\prePersist
     * @ORM\preUpdate
     */
    public function setLastLoginValue()
    {
        $this->lastLogin = new \DateTime();
    }
    
    /**
     * @ORM\prePersist
     */
    public function setInfoValue()
    {
        $simpleXml = simplexml_load_string('<?xml version="1.0" encoding="UTF-8"?><info></info>');
        $this->info = $simpleXml->asXML();
    }
    
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return User
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     * @return User
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    
        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return \DateTime 
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

}