<?php

namespace Base\DiridarekBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Base\DiridarekBundle\Entity\Amis;

class AmisData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $amis1 = new Amis();
        $amis1->setUserSent($this->getReference('user1'));
        $amis1->setUserReceive($this->getReference('user2'));
        $amis1->setEtat("1");
        $amis1->setIp('127.0.0.1');
        $manager->persist($amis1);
        
        $amis2 = new Amis();
        $amis2->setUserSent($this->getReference('user2'));
        $amis2->setUserReceive($this->getReference('user3'));
        $amis2->setEtat("1");
        $amis2->setIp('127.0.0.1');
        $manager->persist($amis2);
        
        $amis3 = new Amis();
        $amis3->setUserSent($this->getReference('user3'));
        $amis3->setUserReceive($this->getReference('user4'));
        $amis3->setEtat("1");
        $amis3->setIp('127.0.0.1');
        $manager->persist($amis3);
        
        $amis4 = new Amis();
        $amis4->setUserSent($this->getReference('user4'));
        $amis4->setUserReceive($this->getReference('user1'));
        $amis4->setEtat("1");
        $amis4->setIp('127.0.0.1');
        $manager->persist($amis4);
        
        $amis5 = new Amis();
        $amis5->setUserSent($this->getReference('user1'));
        $amis5->setUserReceive($this->getReference('user5'));
        $amis5->setEtat("1");
        $amis5->setIp('127.0.0.1');
        $manager->persist($amis5);
        
        $amis6 = new Amis();
        $amis6->setUserSent($this->getReference('user6'));
        $amis6->setUserReceive($this->getReference('user1'));
        $amis6->setEtat("1");
        $amis6->setIp('127.0.0.1');
        $manager->persist($amis6);
        
        $amis7 = new Amis();
        $amis7->setUserSent($this->getReference('user7'));
        $amis7->setUserReceive($this->getReference('user2'));
        $amis7->setEtat("1");
        $amis7->setIp('127.0.0.1');
        $manager->persist($amis7);
        
        $amis8 = new Amis();
        $amis8->setUserSent($this->getReference('user8'));
        $amis8->setUserReceive($this->getReference('user1'));
        $amis8->setEtat("1");
        $amis8->setIp('127.0.0.1');
        $manager->persist($amis8);
        
        $amis9 = new Amis();
        $amis9->setUserSent($this->getReference('user9'));
        $amis9->setUserReceive($this->getReference('user2'));
        $amis9->setEtat("1");
        $amis9->setIp('127.0.0.1');
        $manager->persist($amis9);
        
        $amis10 = new Amis();
        $amis10->setUserSent($this->getReference('user10'));
        $amis10->setUserReceive($this->getReference('user3'));
        $amis10->setEtat("1");
        $amis10->setIp('127.0.0.1');
        $manager->persist($amis10);
        
        $amis11 = new Amis();
        $amis11->setUserSent($this->getReference('user1'));
        $amis11->setUserReceive($this->getReference('user12'));
        $amis11->setEtat("1");
        $amis11->setIp('127.0.0.1');
        $manager->persist($amis11);
        
        $amis12 = new Amis();
        $amis12->setUserSent($this->getReference('user1'));
        $amis12->setUserReceive($this->getReference('user13'));
        $amis12->setEtat("1");
        $amis12->setIp('127.0.0.1');
        $manager->persist($amis12);
        
        $amis13 = new Amis();
        $amis13->setUserSent($this->getReference('user10'));
        $amis13->setUserReceive($this->getReference('user2'));
        $amis13->setEtat("1");
        $amis13->setIp('127.0.0.1');
        $manager->persist($amis13);
        
        $amis14 = new Amis();
        $amis14->setUserSent($this->getReference('user13'));
        $amis14->setUserReceive($this->getReference('user2'));
        $amis14->setEtat("1");
        $amis14->setIp('127.0.0.1');
        $manager->persist($amis14);
        
        $amis15 = new Amis();
        $amis15->setUserSent($this->getReference('user2'));
        $amis15->setUserReceive($this->getReference('user12'));
        $amis15->setEtat("1");
        $amis15->setIp('127.0.0.1');
        $manager->persist($amis15);
        
        $manager->flush();
        
        $this->addReference('amis1',  $amis1);
        $this->addReference('amis2',  $amis2);
        $this->addReference('amis3',  $amis3);
        $this->addReference('amis4',  $amis4);
        $this->addReference('amis5',  $amis5);
        $this->addReference('amis6',  $amis6);
        $this->addReference('amis7',  $amis7);
        $this->addReference('amis8',  $amis8);
        $this->addReference('amis9',  $amis9);
        $this->addReference('amis10', $amis10);
        $this->addReference('amis11', $amis11);
        $this->addReference('amis12', $amis12);
        $this->addReference('amis13', $amis13);
        $this->addReference('amis14', $amis14);
        $this->addReference('amis15', $amis15);
    }
    
    public function getOrder()
    {
        return 3; // l'ordre dans lequel les fichiers sont chargés
    }
}
