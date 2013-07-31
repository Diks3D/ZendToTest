<?php

namespace Dashboard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *  @ORM\Entity
 *  @ORM\Table(name="ad_auth_storage")
 *  @ORM\HasLifecycleCallbacks()
 */
class Auth
{
    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="User")
     */
    protected $userId;
    
    /**
     * @ORM\Column(type="string", unique=true, length=100)
     */
    protected $login;
    
    /**
     * @ORM\Column(type="string", unique=true, length=150)
     */
    protected $email;
    
    /** 
     * @ORM\Column(name="token_hash", type="string", length=40)
     */
    protected $token;

   /**
     *  @ORM\Column(type="start_time", type="datetime")
     *  @var \DateTime
     */
    protected $startTime;
    
    /**
     *  @ORM\Column(name="end_time", type="datetime")
     *  @var \DateTime
     */
    protected $endTime;

    /**
     * @ORM\prePersist
     * @var \DateTime
     */
    public function setStartTimeValue()
    {
        $this->startTime = new \DateTime();
    }
    
    /**
     * @ORM\prePersist
     */
    public function setEndTimeValue()
    {
        $this->endTime = new \DateTime();
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
     * Set userId
     *
     * @param integer $userId
     * @return Auth
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    
        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return Auth
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
     * @return Auth
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
     * Set token
     *
     * @param string $token
     * @return Auth
     */
    public function setToken($token)
    {
        $this->token = $token;
    
        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     * @return Auth
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    
        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime 
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     * @return Auth
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    
        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime 
     */
    public function getEndTime()
    {
        return $this->endTime;
    }
}