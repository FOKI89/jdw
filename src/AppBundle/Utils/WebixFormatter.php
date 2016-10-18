<?php
namespace AppBundle\Utils;
use AppBundle\Entity\Folder;

/**
 * Created by PhpStorm.
 * User: adelise
 * Date: 18/10/2016
 * Time: 12:14
 */
class WebixFormatter
{
    /**
     * @param Folder $folder
     *
     * @return array
     */
    public function formatRootFolder(Folder $folder) {
        return [
            'id' => 'root',
            'value' => $folder->getName(),
            'type' => 'folder',
            'size' => 0,
            'date' => 0,
            'open' => true,
            'data' =>  array(),
        ];
    }

    public function formatFolders(array $folders)
    {
        $formatResult = array();
        foreach($folders as $folder) {
            $formatResult[] = array(
                'id' => $folder->getId(),
                'value' => $folder->getName(),
                'type' => 'folder',
                'size' => 0,
                'date' => $folder->getCreationDate()->getTimestamp(),
                'webix_files' => 1
            );
        }

        return $formatResult;
    }

    public function format(Folder $rootFolder, array $folders) {
        $rootFolderFormat = $this->formatRootFolder($rootFolder);
        $rootFolderFormat['data'] = $this->formatFolders($folders);

        return array($rootFolderFormat);
    }

}