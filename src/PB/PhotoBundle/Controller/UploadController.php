<?php

namespace PB\PhotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UploadController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PBPhotoBundle:Upload:upload.html.twig');
    }
}
