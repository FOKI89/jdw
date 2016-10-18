<?php
namespace AppBundle\Manager;

use AppBundle\Entity\Title;
use Doctrine\ORM\EntityManager;

class TitleManager
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function saveTitle(Title $tile)
    {
        $this->em->persist($tile);
        $this->em->flush();
    }

}