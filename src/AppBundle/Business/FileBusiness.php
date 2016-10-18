<?php
namespace AppBundle\Business;

use AppBundle\Entity\File;
use AppBundle\Entity\User;
use AppBundle\Manager\FileManager;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Created by PhpStorm.
 * User: adelise
 * Date: 07/10/2016
 * Time: 16:09
 */
class FileBusiness
{
    private $file_manager;

    public function __construct(FileManager $fileManager)
    {
        $this->file_manager = $fileManager;
    }

    public function createUploadedFileBusiness(UploadedFile $uploadedFile, User $user, $folderId){
        $file = new File();
        $file->setUserId($user->getId());
        is_integer($folderId) ? $file->setFolderId($folderId) : $file->setFolderId(null);
        $file->setName($uploadedFile->getClientOriginalName());
        $file->setType($uploadedFile->getMimeType());
        $file->setCreationDate(new \DateTime('now'));
        $file->setSize($uploadedFile->getSize());
        $this->file_manager->saveFile($file);
    }

    public function deleteFileBusiness(String $fileId, User $user)
    {
        $file = $this->file_manager->findByField('name', $fileId, $user->getId());
        $this->file_manager->deleteFile($file);
    }

}