<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Contact;
use AppBundle\Form\Contact\CreateContact;
use AppBundle\Form\Title\NewTitle;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;


class ContactController extends Controller implements ClassResourceInterface
{
    private function _createNewContactForm(Contact $contact)
    {
        $contact->setUserId($this->getUser()->getId());
        $em = $this->getDoctrine()->getManager();

        $contactForm = $this->createForm(CreateContact::class, $contact, array(
            'title_repository' => $em->getRepository('AppBundle:Title'),
            'userId' => $this->getUser()->getId()
        ));
        return $contactForm;
    }

    /**
     * @Route("/contacts/add", name="add_contact");
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request)
    {
        $contact = new Contact();
        $contactForm = $this->_createNewContactForm($contact);

        $contactForm->handleRequest($request);
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $this->get('contact.manager')->saveContact($contact);
            $this->addFlash('success', $this->get('translator')->trans('add_contact.success'));
            return $this->redirect('/contacts/add');
        }
        
        $titleForm = $this->createForm(NewTitle::class);

        return $this->render('contact/create_contact.html.twig', array(
            'contact_form' => $contactForm->createView(),
            'title_form' => $titleForm->createView()
        ));
    }

    /**
     * @Post("/api/contacts")
     */
    public function postAction(Request $request)
    {
        $contact = new Contact();
        $contactForm = $this->_createNewContactForm($contact);
        $contactForm->submit($request->request->all());
        if ($contactForm->isValid()) {
            $this->get('contact.manager')->saveContact($contact);
            return View::create($contact, Codes::HTTP_CREATED);
        }

        return View::create($contactForm, Codes::HTTP_BAD_REQUEST);
    }
}
