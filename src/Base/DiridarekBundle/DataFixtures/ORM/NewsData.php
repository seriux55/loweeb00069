<?php

namespace Base\DiridarekBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Base\DiridarekBundle\Entity\News;

class NewsData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $news1 = new News();
        $news1->setUser($this->getReference('user1'))
        ->setType("1")
        ->setProfil("")
        ->setDescribH("Il était une fois")
        ->setSearchH("Il était une fois")
        ->setStatutH("Il était une fois")
        ->setJoinH("")
        ->setAlbumH("")
        ->setPhotoH("")
        ->setIp('127.0.0.1')
        ->setDateTime(new \DateTime('2015-01-01 00:00:00'));
        $manager->persist($news1);
        
        $news2 = new News();
        $news2->setUser($this->getReference('user2'))
        ->setType("1")
        ->setProfil("")
        ->setDescribH("Il était une fois")
        ->setSearchH("Il était une fois")
        ->setStatutH("Il était une fois")
        ->setJoinH("")
        ->setAlbumH("")
        ->setPhotoH("")
        ->setIp('127.0.0.1')
        ->setDateTime(new \DateTime('2015-01-01 00:00:00'));
        $manager->persist($news2);
        
        $news3 = new News();
        $news3->setUser($this->getReference('user3'))
        ->setType("1")
        ->setProfil("")
        ->setDescribH("Il était une fois")
        ->setSearchH("Il était une fois")
        ->setStatutH("Il était une fois")
        ->setJoinH("")
        ->setAlbumH("")
        ->setPhotoH("")
        ->setIp('127.0.0.1')
        ->setDateTime(new \DateTime('2015-01-01 00:00:00'));
        $manager->persist($news3);
        
        $news4 = new News();
        $news4->setUser($this->getReference('user4'))
        ->setType("1")
        ->setProfil("")
        ->setDescribH("Il était une fois")
        ->setSearchH("Il était une fois")
        ->setStatutH("Il était une fois")
        ->setJoinH("")
        ->setAlbumH("")
        ->setPhotoH("")
        ->setIp('127.0.0.1')
        ->setDateTime(new \DateTime('2015-01-01 00:00:00'));
        $manager->persist($news4);
        
        $news5 = new News();
        $news5->setUser($this->getReference('user5'))
        ->setType("1")
        ->setProfil("")
        ->setDescribH("Il était une fois")
        ->setSearchH("Il était une fois")
        ->setStatutH("Il était une fois")
        ->setJoinH("")
        ->setAlbumH("")
        ->setPhotoH("")
        ->setIp('127.0.0.1')
        ->setDateTime(new \DateTime('2015-01-01 00:00:00'));
        $manager->persist($news5);
        
        $news6 = new News();
        $news6->setUser($this->getReference('user6'))
        ->setType("1")
        ->setProfil("")
        ->setDescribH("Il était une fois")
        ->setSearchH("Il était une fois")
        ->setStatutH("Il était une fois")
        ->setJoinH("")
        ->setAlbumH("")
        ->setPhotoH("")
        ->setIp('127.0.0.1')
        ->setDateTime(new \DateTime('2015-01-01 00:00:00'));
        $manager->persist($news6);
        
        $news7 = new News();
        $news7->setUser($this->getReference('user7'))
        ->setType("1")
        ->setProfil("")
        ->setDescribH("Il était une fois")
        ->setSearchH("Il était une fois")
        ->setStatutH("Il était une fois")
        ->setJoinH("")
        ->setAlbumH("")
        ->setPhotoH("")
        ->setIp('127.0.0.1')
        ->setDateTime(new \DateTime('2015-01-01 00:00:00'));
        $manager->persist($news7);
        
        $news8 = new News();
        $news8->setUser($this->getReference('user8'))
        ->setType("1")
        ->setProfil("")
        ->setDescribH("Il était une fois")
        ->setSearchH("Il était une fois")
        ->setStatutH("Il était une fois")
        ->setJoinH("")
        ->setAlbumH("")
        ->setPhotoH("")
        ->setIp('127.0.0.1')
        ->setDateTime(new \DateTime('2015-01-01 00:00:00'));
        $manager->persist($news8);
        
        $news9 = new News();
        $news9->setUser($this->getReference('user9'))
        ->setType("1")
        ->setProfil("")
        ->setDescribH("Il était une fois")
        ->setSearchH("Il était une fois")
        ->setStatutH("Il était une fois")
        ->setJoinH("")
        ->setAlbumH("")
        ->setPhotoH("")
        ->setIp('127.0.0.1')
        ->setDateTime(new \DateTime('2015-01-01 00:00:00'));
        $manager->persist($news9);
        
        $news10 = new News();
        $news10->setUser($this->getReference('user10'))
        ->setType("1")
        ->setProfil("")
        ->setDescribH("Il était une fois")
        ->setSearchH("Il était une fois")
        ->setStatutH("Il était une fois")
        ->setJoinH("")
        ->setAlbumH("")
        ->setPhotoH("")
        ->setIp('127.0.0.1')
        ->setDateTime(new \DateTime('2015-01-01 00:00:00'));
        $manager->persist($news10);
        
        $news11 = new News();
        $news11->setUser($this->getReference('user11'))
        ->setType("1")
        ->setProfil("")
        ->setDescribH("Il était une fois")
        ->setSearchH("Il était une fois")
        ->setStatutH("Il était une fois")
        ->setJoinH("")
        ->setAlbumH("")
        ->setPhotoH("")
        ->setIp('127.0.0.1')
        ->setDateTime(new \DateTime('2015-01-01 00:00:00'));
        $manager->persist($news11);
        
        $news12 = new News();
        $news12->setUser($this->getReference('user12'))
        ->setType("1")
        ->setProfil("")
        ->setDescribH("Il était une fois")
        ->setSearchH("Il était une fois")
        ->setStatutH("Il était une fois")
        ->setJoinH("")
        ->setAlbumH("")
        ->setPhotoH("")
        ->setIp('127.0.0.1')
        ->setDateTime(new \DateTime('2015-01-01 00:00:00'));
        $manager->persist($news12);
        
        $news13 = new News();
        $news13->setUser($this->getReference('user13'))
        ->setType("1")
        ->setProfil("")
        ->setDescribH("Il était une fois")
        ->setSearchH("Il était une fois")
        ->setStatutH("Il était une fois")
        ->setJoinH("")
        ->setAlbumH("")
        ->setPhotoH("")
        ->setIp('127.0.0.1')
        ->setDateTime(new \DateTime('2015-01-01 00:00:00'));
        $manager->persist($news13);
        
        $news14 = new News();
        $news14->setUser($this->getReference('user14'))
        ->setType("1")
        ->setProfil("")
        ->setDescribH("Il était une fois")
        ->setSearchH("Il était une fois")
        ->setStatutH("Il était une fois")
        ->setJoinH("")
        ->setAlbumH("")
        ->setPhotoH("")
        ->setIp('127.0.0.1')
        ->setDateTime(new \DateTime('2015-01-01 00:00:00'));
        $manager->persist($news14);
        
        $news15 = new News();
        $news15->setUser($this->getReference('user15'))
        ->setType("1")
        ->setProfil("")
        ->setDescribH("Il était une fois")
        ->setSearchH("Il était une fois")
        ->setStatutH("Il était une fois")
        ->setJoinH("")
        ->setAlbumH("")
        ->setPhotoH("")
        ->setIp('127.0.0.1')
        ->setDateTime(new \DateTime('2015-01-01 00:00:00'));
        $manager->persist($news15);
        
        $manager->flush();
        
        $this->addReference('news1',  $news1);
        $this->addReference('news2',  $news2);
        $this->addReference('news3',  $news3);
        $this->addReference('news4',  $news4);
        $this->addReference('news5',  $news5);
        $this->addReference('news6',  $news6);
        $this->addReference('news7',  $news7);
        $this->addReference('news8',  $news8);
        $this->addReference('news9',  $news9);
        $this->addReference('news10', $news10);
        $this->addReference('news11', $news11);
        $this->addReference('news12', $news12);
        $this->addReference('news13', $news13);
        $this->addReference('news14', $news14);
        $this->addReference('news15', $news15);
    }
    
    public function getOrder()
    {
        return 2; // l'ordre dans lequel les fichiers sont chargés
    }
}
