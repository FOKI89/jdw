<?php
namespace AppBundle\Manager;

use AppBundle\Entity\Contact;
use Doctrine\ORM\EntityManager;

class ContactManager
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function saveContact(Contact $tile)
    {
        $this->em->persist($tile);
        $this->em->flush();
    }
    
    

}