<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Title;
use AppBundle\Form\Title\NewTitle;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class TitleController extends FOSRestController
{
    /**
     * @Route("/titles", name="_getTitles")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $titles = $em->getRepository('AppBundle:Title')
            ->findByUserId($this->getUser()->getId());

        $json = array();
        foreach ($titles as $title) {
            $json[] = array('id' => $title->getId(), 'text' => $title->getLabel());
        }
        return new JsonResponse($json);
    }

    /**
     * @Route("/titles/add", name="_addTitle");
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function addAction(Request $request)
    {
        $title = new Title();
        $title->setUserId($this->getUser()->getId());

        $form = $this->createForm(NewTitle::class, $title);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('title.manager')->saveTitle($title);
            return new JsonResponse(array('value' => $title->getId()));
        }

        return $this->render('title/add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Post("/api/titles", name="addTitle")
     */
    public function postAction(Request $request)
    {
        $title = new Title();
        $title->setUserId($this->getUser()->getId());

        $form = $this->createForm(NewTitle::class, $title);
        $form->submit($request->request->all());
        if ($form->isValid()) {
            $this->get('title.manager')->saveTitle($title);
            return View::create($title, Codes::HTTP_CREATED);
        }

        return View::create($form, Codes::HTTP_BAD_REQUEST);
    }
}
