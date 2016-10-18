<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Matter;
use AppBundle\Form\Matter\CreateMatter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MatterController extends Controller
{
    /**
     * @Route("/matters/add", name="add_matter");
     * @param Request $request
     */
    public function addAction(Request $request)
    {
        $matter = new Matter();
        $matter->setUserId($this->getUser()->getId());

        $matterForm = $this->createForm(CreateMatter::class, $matter);

        $matterForm->handleRequest($request);
        if ($matterForm->isSubmitted() && $matterForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($matter);
            $em->flush();
            $this->addFlash('success', $this->get('translator')->trans('add_matter.success'));
            return $this->redirect('/matters/add');
        }
        
        return $this->render('matter/create_matter.html.twig', array(
            'form' => $matterForm->createView()
        ));
    }
}
