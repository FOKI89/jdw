<?php
/**
 * Created by PhpStorm.
 * User: Mau
 * Date: 09/10/2016
 * Time: 17:38
 */

namespace AppBundle\Business;


use AppBundle\Entity\Folder;
use AppBundle\Entity\User;
use AppBundle\Manager\FolderManager;

class FolderBusiness
{
    private $folder_manager;
    const DEFAULT_NAME_FOLDER = "newFolder";

    public function __construct(FolderManager $folderManager)
    {
        $this->folder_manager = $folderManager;
    }

    public function createFolderBusiness($folderId, User $user){
        $folder = new Folder();
        is_integer($folderId) ? $folder->setFolderId($folderId) : $folder->setFolderId(null);
        $folder->setUserId($user->getId());
        $folder->setName(self::DEFAULT_NAME_FOLDER);
        $folder->setCreationDate(new \DateTime('now'));
        $this->folder_manager->saveFolder($folder);
    }

}