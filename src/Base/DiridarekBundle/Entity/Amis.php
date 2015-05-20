<?php

namespace Base\DiridarekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Amis
 *
 * @ORM\Table(name="diridarek__Amis")
 * @ORM\Entity(repositoryClass="Base\DiridarekBundle\Entity\AmisRepository")
 */
class Amis
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
     * Le constructeur
     */
    public function __construct()
    {
        $this->fin      = new \Datetime();
        $this->vue      = "0";
        $this->dateTime = new \Datetime();
    }
    
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
     * @ORM\Column(name="vue", type="string", length=255)
     */
    private $vue;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fin", type="datetime")
     */
    private $fin;

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
     * @return Amis
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
     * @return Amis
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
     * Set etat
     *
     * @param string $etat
     * @return Amis
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
     * Set vue
     *
     * @param string $vue
     * @return Amis
     */
    public function setVue($vue)
    {
        $this->vue = $vue;

        return $this;
    }

    /**
     * Get vue
     *
     * @return string 
     */
    public function getVue()
    {
        return $this->vue;
    }

    /**
     * Set fin
     *
     * @param \DateTime $fin
     * @return Amis
     */
    public function setFin($fin)
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * Get fin
     *
     * @return \DateTime 
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return Amis
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
     * @return Amis
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
