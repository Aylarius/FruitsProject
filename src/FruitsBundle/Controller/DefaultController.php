<?php

namespace FruitsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FruitsBundle:Default:index.html.twig');
    }
}
