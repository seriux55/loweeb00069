<?php

namespace Base\DiridarekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Visite
 *
 * @ORM\Table(name="diridarek__Visite")
 * @ORM\Entity(repositoryClass="Base\DiridarekBundle\Entity\VisiteRepository")
 */
class Visite
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
     * @ORM\Column(name="vue", type="string", length=255)
     */
    private $vue;

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
     * @return Visite
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
     * @return Visite
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
     * Set vue
     *
     * @param string $vue
     * @return Visite
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
     * Set ip
     *
     * @param string $ip
     * @return Visite
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
     * @return Visite
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
