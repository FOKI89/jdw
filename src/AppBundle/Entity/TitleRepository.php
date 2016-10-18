<?php
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TitleRepository
 */
class TitleRepository extends EntityRepository implements Selectable
{

    public function checkChoice($value, $parameters)
    {
        $result = $this->findOneBy(array('userId' => $parameters['userId'], 'id' => $value));

        return $result;
    }

}