<?php

namespace Base\DiridarekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="diridarek__Comment")
 * @ORM\Entity(repositoryClass="Base\DiridarekBundle\Entity\CommentRepository")
 */
class Comment
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
     * @ORM\Column(name="smily", type="string", length=255)
     */
    private $smily;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255)
     */
    private $comment;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;

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
     * @return Comment
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
     * @return Comment
     */
    public function setUserReceive(\Base\UserBundle\Entity\User $user_receive)
    {
        $this->user_receive = $user_receive;

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
     * Set smily
     *
     * @param string $smily
     * @return Comment
     */
    public function setSmily($smily)
    {
        $this->smily = $smily;

        return $this;
    }

    /**
     * Get smily
     *
     * @return string 
     */
    public function getSmily()
    {
        return $this->smily;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set etat
     *
     * @param string $etat
     * @return Comment
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string 
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return Comment
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
     * @return Comment
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
