<?php

namespace Base\DiridarekBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BaseDiridarekBundle:Default:index.html.twig');
    }
}
