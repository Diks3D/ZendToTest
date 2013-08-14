<?php

namespace Dashboard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *  @ORM\Entity
 *  @ORM\HasLifecycleCallbacks()
 *  @ORM\Table(name="ad_message")
 */
class Message {
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $user;
    
    /** @ORM\Column(type="string")
     * @var string
     */
    protected $title;
    
    /** @ORM\Column(type="text")
     * @var string
     */
    protected $message;
    
    /**
     *  @ORM\Column(type="string", columnDefinition="ENUM('new', 'active', 'suspend', 'close')", nullable=false)
     *  @var string
     */
    protected $status;
    
    /**
     *  @ORM\Column(type="datetime")
     *  @var DateTime
     */
    protected $created;
    
    /**
     *  @ORM\Column(type="datetime")
     *  @var DateTime
     */
    protected $updated;

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
    public function setUpdatedValue()
    {
        $this->created = new \DateTime();
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
     * Set title
     *
     * @param string $title
     * @return Message
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    
        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Message
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Message
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
     * Set updated
     *
     * @param \DateTime $updated
     * @return Message
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set user
     *
     * @param \Dashboard\Entity\User $user
     * @return Message
     */
    public function setUser(\Dashboard\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Dashboard\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}