<?php
/**
 * Created by PhpStorm.
 * User: adelise
 * Date: 07/10/2016
 * Time: 15:51
 */

namespace AppBundle\Manager;


use AppBundle\Entity\Folder;
use Doctrine\ORM\EntityManager;

class FolderManager
{
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function saveFolder(Folder $folder){
        $this->em->persist($folder);
        $this->em->flush();
    }

    /**
     * @param $userId
     * @param null $folderId
     * @return \AppBundle\Entity\Folder[]
     */
    public function getFoldersByUserId($userId, $folderId = null) {
        $folders = $this->em->getRepository(Folder::class)->findBy(array('userId' => $userId, 'folderId' => $folderId));

        return $folders;
    }

    /**
     * @param $folderId
     * @return Folder
     */
    public function getFolderById($folderId) {
        $folder = $this->em->getRepository(Folder::class)->findOneById($folderId);

        return $folder;
    }

}