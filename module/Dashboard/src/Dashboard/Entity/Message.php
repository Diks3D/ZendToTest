<?php

namespace Dashboard\Entity;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\ORM\ORMInvalidArgumentException as InvalidArgumentException;

/**
 *  @ORM\Entity
 *  @ORM\Table(name="z2t_dashboard_messages")
 *  @ORM\HasLifecycleCallbacks
 */
class Message
{
    const STATUS_OPEN = 'open';
    const STATUS_SUSPEND = 'suspend';
    const STATUS_IN_PROGRESS= 'in_progress';
    const STATUS_CLOSED = 'closed';
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status = 'open';

    /**
     * @ORM\Column(name="create_at", type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(name="update_at", type="datetime")
     */
    private $updated;
    
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
     * @param integer $status
     * @return Message
     */
    public function setStatus($status)
    {
        $validStatuses = array(self::STATUS_OPEN, self::STATUS_SUSPEND, self::STATUS_IN_PROGRESS, self::STATUS_CLOSED);
        if (!in_array($status, $validStatuses)) {
            throw new InvalidArgumentException("Invalid status");
        }
        $this->status = $status;
        
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
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
}
