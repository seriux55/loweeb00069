<?php

namespace Base\DiridarekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * News
 *
 * @ORM\Table(name="diridarek__News")
 * @ORM\Entity(repositoryClass="Base\DiridarekBundle\Entity\NewsRepository")
 */
class News
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
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="profil", type="string", length=255)
     */
    private $profil;

    /**
     * @var string
     *
     * @ORM\Column(name="describ_h", type="string", length=1023)
     */
    private $describH;

    /**
     * @var string
     *
     * @ORM\Column(name="search_h", type="string", length=1023)
     */
    private $searchH;

    /**
     * @var string
     *
     * @ORM\Column(name="statut_h", type="string", length=1023)
     */
    private $statutH;

    /**
     * @var string
     *
     * @ORM\Column(name="join_h", type="string", length=255)
     */
    private $joinH;

    /**
     * @var string
     *
     * @ORM\Column(name="album_h", type="string", length=255)
     */
    private $albumH;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_h", type="string", length=255)
     */
    private $photoH;

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
     * Set user
     *
     * @param \Base\UserBundle\Entity\User $user
     * @return News
     */
    public function setUser(\Base\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Base\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return News
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set profil
     *
     * @param string $profil
     * @return News
     */
    public function setProfil($profil)
    {
        $this->profil = $profil;

        return $this;
    }

    /**
     * Get profil
     *
     * @return string 
     */
    public function getProfil()
    {
        return $this->profil;
    }

    /**
     * Set describH
     *
     * @param string $describH
     * @return News
     */
    public function setDescribH($describH)
    {
        $this->describH = $describH;

        return $this;
    }

    /**
     * Get describH
     *
     * @return string 
     */
    public function getDescribH()
    {
        return $this->describH;
    }

    /**
     * Set searchH
     *
     * @param string $searchH
     * @return News
     */
    public function setSearchH($searchH)
    {
        $this->searchH = $searchH;

        return $this;
    }

    /**
     * Get searchH
     *
     * @return string 
     */
    public function getSearchH()
    {
        return $this->searchH;
    }

    /**
     * Set statutH
     *
     * @param string $statutH
     * @return News
     */
    public function setStatutH($statutH)
    {
        $this->statutH = $statutH;

        return $this;
    }

    /**
     * Get statutH
     *
     * @return string 
     */
    public function getStatutH()
    {
        return $this->statutH;
    }

    /**
     * Set joinH
     *
     * @param string $joinH
     * @return News
     */
    public function setJoinH($joinH)
    {
        $this->joinH = $joinH;

        return $this;
    }

    /**
     * Get joinH
     *
     * @return string 
     */
    public function getJoinH()
    {
        return $this->joinH;
    }

    /**
     * Set albumH
     *
     * @param string $albumH
     * @return News
     */
    public function setAlbumH($albumH)
    {
        $this->albumH = $albumH;

        return $this;
    }

    /**
     * Get albumH
     *
     * @return string 
     */
    public function getAlbumH()
    {
        return $this->albumH;
    }

    /**
     * Set photoH
     *
     * @param string $photoH
     * @return News
     */
    public function setPhotoH($photoH)
    {
        $this->photoH = $photoH;

        return $this;
    }

    /**
     * Get photoH
     *
     * @return string 
     */
    public function getPhotoH()
    {
        return $this->photoH;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return News
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
     * @return News
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
