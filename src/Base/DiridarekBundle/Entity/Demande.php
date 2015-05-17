<?php

namespace Base\DiridarekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Demande
 *
 * @ORM\Table(name="diridarek__Demande")
 * @ORM\Entity(repositoryClass="Base\DiridarekBundle\Entity\DemandeRepository")
 */
class Demande
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
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="confirm", type="string", length=255)
     */
    private $confirm;

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
     * @return Demande
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
     * @return Demande
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
     * Set etat
     *
     * @param string $etat
     * @return Demande
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
     * Set confirm
     *
     * @param string $confirm
     * @return Demande
     */
    public function setConfirm($confirm)
    {
        $this->confirm = $confirm;

        return $this;
    }

    /**
     * Get confirm
     *
     * @return string 
     */
    public function getConfirm()
    {
        return $this->confirm;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return Demande
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
     * @return Demande
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
