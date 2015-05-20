<?php

namespace Base\DiridarekBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Base\DiridarekBundle\Entity\Message;

class MessageData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $message1 = new Message();
        $message1->setUserSent($this->getReference('user1'))
        ->setUserReceive($this->getReference('user2'))
        ->setMessage("Bonjour, ça va? :-)")
        ->setIp('127.0.0.1');
        $manager->persist($message1);
        
        $message2 = new Message();
        $message2->setUserSent($this->getReference('user2'))
        ->setUserReceive($this->getReference('user1'))
        ->setMessage("Bonjour, ça va? :-)")
        ->setIp('127.0.0.1');
        $manager->persist($message2);
        
        $message3 = new Message();
        $message3->setUserSent($this->getReference('user1'))
        ->setUserReceive($this->getReference('user3'))
        ->setMessage("Bonjour, ça va? :-)")
        ->setIp('127.0.0.1');
        $manager->persist($message3);
        
        $message4 = new Message();
        $message4->setUserSent($this->getReference('user1'))
        ->setUserReceive($this->getReference('user4'))
        ->setMessage("Bonjour, ça va? :-)")
        ->setIp('127.0.0.1');
        $manager->persist($message4);
        
        $message5 = new Message();
        $message5->setUserSent($this->getReference('user1'))
        ->setUserReceive($this->getReference('user5'))
        ->setMessage("Bonjour, ça va? :-)")
        ->setIp('127.0.0.1');
        $manager->persist($message5);
        
        $message6 = new Message();
        $message6->setUserSent($this->getReference('user6'))
        ->setUserReceive($this->getReference('user1'))
        ->setMessage("Bonjour, ça va? :-)")
        ->setIp('127.0.0.1');
        $manager->persist($message6);
        
        $message7 = new Message();
        $message7->setUserSent($this->getReference('user1'))
        ->setUserReceive($this->getReference('user6'))
        ->setMessage("Bonjour, ça va? :-)")
        ->setIp('127.0.0.1');
        $manager->persist($message7);
        
        $message8 = new Message();
        $message8->setUserSent($this->getReference('user1'))
        ->setUserReceive($this->getReference('user6'))
        ->setMessage("Bonjour, ça va? :-)")
        ->setIp('127.0.0.1');
        $manager->persist($message8);
        
        $message9 = new Message();
        $message9->setUserSent($this->getReference('user2'))
        ->setUserReceive($this->getReference('user7'))
        ->setMessage("Bonjour, ça va? :-)")
        ->setIp('127.0.0.1');
        $manager->persist($message9);
        
        $message10 = new Message();
        $message10->setUserSent($this->getReference('user2'))
        ->setUserReceive($this->getReference('user8'))
        ->setMessage("Bonjour, ça va? :-)")
        ->setIp('127.0.0.1');
        $manager->persist($message10);
        
        $message11 = new Message();
        $message11->setUserSent($this->getReference('user10'))
        ->setUserReceive($this->getReference('user2'))
        ->setMessage("Bonjour, ça va? :-)")
        ->setIp('127.0.0.1');
        $manager->persist($message11);
        
        $message12 = new Message();
        $message12->setUserSent($this->getReference('user11'))
        ->setUserReceive($this->getReference('user2'))
        ->setMessage("Bonjour, ça va? :-)")
        ->setIp('127.0.0.1');
        $manager->persist($message12);
        
        $message13 = new Message();
        $message13->setUserSent($this->getReference('user12'))
        ->setUserReceive($this->getReference('user2'))
        ->setMessage("Bonjour, ça va? :-)")
        ->setIp('127.0.0.1');
        $manager->persist($message13);
        
        $message14 = new Message();
        $message14->setUserSent($this->getReference('user2'))
        ->setUserReceive($this->getReference('user3'))
        ->setMessage("Bonjour, ça va? :-)")
        ->setIp('127.0.0.1');
        $manager->persist($message14);
        
        $message15 = new Message();
        $message15->setUserSent($this->getReference('user2'))
        ->setUserReceive($this->getReference('user4'))
        ->setMessage("Bonjour, ça va? :-)")
        ->setIp('127.0.0.1');
        $manager->persist($message15);
        
        $manager->flush();
        
        $this->addReference('message1',  $message1);
        $this->addReference('message2',  $message2);
        $this->addReference('message3',  $message3);
        $this->addReference('message4',  $message4);
        $this->addReference('message5',  $message5);
        $this->addReference('message6',  $message6);
        $this->addReference('message7',  $message7);
        $this->addReference('message8',  $message8);
        $this->addReference('message9',  $message9);
        $this->addReference('message10', $message10);
        $this->addReference('message11', $message11);
        $this->addReference('message12', $message12);
        $this->addReference('message13', $message13);
        $this->addReference('message14', $message14);
        $this->addReference('message15', $message15);
    }
    
    public function getOrder()
    {
        return 4; // l'ordre dans lequel les fichiers sont chargés
    }
}
