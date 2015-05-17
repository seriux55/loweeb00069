<?php

namespace Base\DiridarekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="diridarek__Message")
 * @ORM\Entity(repositoryClass="Base\DiridarekBundle\Entity\MessageRepository")
 */
class Message
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Base\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_sent;
    
    /**
     * @ORM\ManyToOne(targetEntity="Base\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_receive;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=511)
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="lut", type="string", length=255)
     */
    private $lut;

    /**
     * @var string
     *
     * @ORM\Column(name="del_first", type="string", length=255)
     */
    private $delFirst;

    /**
     * @var string
     *
     * @ORM\Column(name="del_seconde", type="string", length=255)
     */
    private $delSeconde;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lecture", type="datetime")
     */
    private $lecture;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=255)
     */
    private $ip;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_time", type="datetime")
     */
    private $dateTime;


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
     * Set user_sent
     *
     * @param \Base\UserBundle\Entity\User $user_sent
     * @return Message
     */
    public function setUserSent(\Base\UserBundle\Entity\User $user_sent)
    {
        $this->user_sent = $user_sent;

        return $this;
    }

    /**
     * Get user_sent
     *
     * @return \Base\UserBundle\Entity\User
     */
    public function getUserSent()
    {
        return $this->user_sent;
    }

    /**
     * Set user_receive
     *
     * @param \Base\UserBundle\Entity\User $user_receive
     * @return Message
     */
    public function setUserReceive(\Base\UserBundle\Entity\User $user_receive)
    {
        $this->user_accepte = $user_receive;

        return $this;
    }

    /**
     * Get user_receive
     *
     * @return \Base\UserBundle\Entity\User
     */
    public function getUserReceive()
    {
        return $this->user_receive;
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
     * Set lut
     *
     * @param string $lut
     * @return Message
     */
    public function setLut($lut)
    {
        $this->lut = $lut;

        return $this;
    }

    /**
     * Get lut
     *
     * @return string 
     */
    public function getLut()
    {
        return $this->lut;
    }

    /**
     * Set delFirst
     *
     * @param string $delFirst
     * @return Message
     */
    public function setDelFirst($delFirst)
    {
        $this->delFirst = $delFirst;

        return $this;
    }

    /**
     * Get delFirst
     *
     * @return string 
     */
    public function getDelFirst()
    {
        return $this->delFirst;
    }

    /**
     * Set delSeconde
     *
     * @param string $delSeconde
     * @return Message
     */
    public function setDelSeconde($delSeconde)
    {
        $this->delSeconde = $delSeconde;

        return $this;
    }

    /**
     * Get delSeconde
     *
     * @return string 
     */
    public function getDelSeconde()
    {
        return $this->delSeconde;
    }

    /**
     * Set lecture
     *
     * @param \DateTime $lecture
     * @return Message
     */
    public function setLecture($lecture)
    {
        $this->lecture = $lecture;

        return $this;
    }

    /**
     * Get lecture
     *
     * @return \DateTime 
     */
    public function getLecture()
    {
        return $this->lecture;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return Message
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set dateTime
     *
     * @param \DateTime $dateTime
     * @return Message
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    /**
     * Get dateTime
     *
     * @return \DateTime 
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }
}
