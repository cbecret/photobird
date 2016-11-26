<?php

namespace PB\PhotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PBPhotoBundle:Default:index.html.twig');
    }
}
