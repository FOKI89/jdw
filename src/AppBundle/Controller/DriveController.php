<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Form\Contact\CreateContact;
use AppBundle\Form\Title\NewTitle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DriveController extends Controller
{
    /**
     * @Route("/drive", name="jarvis_drive")
     */
    public function indexAction(Request $request)
    {
        return $this->render('drive/index.html.twig');
    }

}
