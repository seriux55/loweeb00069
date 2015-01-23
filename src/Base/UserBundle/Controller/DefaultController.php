<?php

namespace Base\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BaseUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
