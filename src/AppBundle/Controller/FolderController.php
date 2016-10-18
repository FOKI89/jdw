<?php
/**
 * Created by PhpStorm.
 * User: adelise
 * Date: 07/10/2016
 * Time: 17:02
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class FolderController extends Controller
{
    /**
     * @Route("/folder/add/{folderId}", name="create_folder", options={"expose"=true})
     */
    public function createAction(Request $request, $folderId){
        $folderBusiness = $this->get('folder.business');
        $folderBusiness->createFolderBusiness($folderId, $this->getUser());
        return new JsonResponse(array('status' => 'server'));
    }

}