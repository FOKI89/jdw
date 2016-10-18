<?php
/**
 * Created by PhpStorm.
 * User: adelise
 * Date: 07/10/2016
 * Time: 15:51
 */

namespace AppBundle\Manager;

use AppBundle\Entity\File;
use Doctrine\ORM\EntityManager;

class FileManager
{
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function saveFile(File $file)
    {
        $this->em->persist($file);
        $this->em->flush();
    }

    public function deleteFile(File $file)
    {
        $this->em->remove($file);
        $this->em->flush();
    }

    public function findByField(String $field, $param, $userId)
    {
        $file = $this->em->getRepository(File::class)->findOneBy(
            array($field => $param, 'userId' => $userId)
        );
        return $file;
    }

    public function getFilesByUserId($userId, $folderId = null){
        $files = $this->em->getRepository(File::class)->findBy(['userId' => $userId, 'folderId' => $folderId]);

        return $files;
    }
}