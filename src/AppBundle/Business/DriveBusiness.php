<?php
/**
 * Created by PhpStorm.
 * User: adelise
 * Date: 17/10/2016
 * Time: 14:31
 */

namespace AppBundle\Business;

use AppBundle\Entity\Folder;
use AppBundle\Manager\FileManager;
use AppBundle\Manager\FolderManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class DriveBusiness
{
    private $file_manager;
    private $folder_manager;
    private $token_storage;
    const FOLDER_TYPE = "folder";
    const ROOT_FOLDER = "root";

    public function __construct(FileManager $fileManager, FolderManager $folderManager, TokenStorage $tokenStorage)
    {
        $this->file_manager = $fileManager;
        $this->folder_manager = $folderManager;
        $this->token_storage = $tokenStorage;
    }

    public function loadRootFolders(){
        $folders = $this->folder_manager->getFoldersByUserId($this->token_storage->getToken()->getUser()->getId());
        $files = $this->file_manager->getFilesByUserId($this->token_storage->getToken()->getUser()->getId());
    }


    public function findJarvisDriveContent($folderId){
        $folderId == "root"  ? $folderId = null : "";
        $folders = $this->folder_manager->findAllByIdUser($folderId, $this->token_storage->getToken()->getUser());

        //$files = $this->file_manager->findAllByIdUser($folderId, $this->token_storage->getToken()->getUser());
        $content = $this->formateFoldersJson($folders);

    }

    private function formateFoldersJson($folders){
        $foldersArray = [];
        foreach ($folders as $folder){
            $foldersArray = [
                'id' => $folder->getId(),
                'value' => $folder->getName(),
                'type' => self::FOLDER_TYPE,
                'size' => '0',
                'date' => $folder->getCreationDate()
            ];
        }
        return $foldersArray;
    }


    private function generateDriveContent($formateJsonContent){
        $dummyFiles = array(
            'id' => 'Dossier',
            'data' => array(
                array(
                    'id' => "root",
                    'value' => 'JarvisDrive',
                    'type' => 'folder',
                    'date' => 1420717913,
                    'data' => $formateJsonContent,
                ),
            )
        );
        return new JsonResponse($dummyFiles);
    }


}