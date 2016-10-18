<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Entity\Folder;
use AppBundle\Form\Contact\CreateContact;
use AppBundle\Form\Title\NewTitle;
use AppBundle\Utils\WebixFormatter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{
    /**
     * @Route("/files", name="get_files", options={"expose"=true})
     */
    public function indexAction(Request $request)
    {
        $folders = $this->getDoctrine()->getRepository('AppBundle:Folder')->findBy(['folderId' => null, 'userId' => $this->getUser()->getId()]);
        $rootFolder = new Folder();
        $rootFolder->setName('Root Folder');
        $webixFormatter = new WebixFormatter();
        return new JsonResponse($webixFormatter->format($rootFolder, $folders));
    }
    /**
     * @Route("/files/dynamic", name="data_dyn", options={"expose"=true})
     * @param Request $request
     * @return JsonResponse
     */
    public function loadDataDynamicAction(Request $request)
    {
        $action = $request->get('action');
        $source = $request->get('source');
        $folder = $this->getDoctrine()->getRepository('AppBundle:Folder')->find($source);
        $folders = $this->getDoctrine()->getRepository('AppBundle:Folder')->findBy(['folderId' => 1, 'userId' => $this->getUser()->getId()]);
        $files = $this->getDoctrine()->getRepository('AppBundle:File')->findBy(['folderId' => $source, 'userId' => $this->getUser()->getId()]);
        if (!empty($folders)) {
            foreach ($folders as $fold) {
                $contentTab[] = [
                    'id' => $fold->getId(),
                    'value' => $fold->getName(),
                    'type' => 'folder',
                    'size' => 0,
                    'date' => $fold->getCreationDate()->getTimestamp(),
                    'webix_files' => 1,
                ];
            }
        } else {
            $contentTab = [];
        }
        $dynTab = [
            'parent' => $folder->getId(),
            'data' => $contentTab,
            'open' => true
        ];
        return new JsonResponse($dynTab);
    }
    /**
     * @Route("/files/add/{folderId}", name="create_file", options={"expose"=true})
     */
    public function createAction(Request $request, $folderId = null)
    {
        $file = $request->files->get('upload');
        $fileSystem = $this->get('oneup_flysystem.jarvis_filesystem');
        $fileBusiness = $this->get('file.business');
        $fileBusiness->createUploadedFileBusiness($file, $this->getUser(), $folderId);
        $fileSystem->write($file->getClientOriginalName(), file_get_contents($file->getPathname()));
        return new JsonResponse(array('status' => 'server'));
    }

    /**
     * @Route("/files/download:{fileId}", name="download_file", options={"expose"=true})
     * @param String $fileId
     * @return Response
     */
    public function downloadAction(String $fileId)
    {
        $fileSystem = $this->get('oneup_flysystem.jarvis_filesystem');
        $fileSystem->addPlugin(new \League\Flysystem\Plugin\GetWithMetadata());
        $stream = $fileSystem->read($fileId);
        $info = $fileSystem->getWithMetadata($fileId, ['size','mimetype']);

        $response = new Response();
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', $info['mimetype']);
        $response->headers->set('Content-Disposition', 'attachment; filename="' . basename($fileId) . '";');
        $response->headers->set('Content-length', $info['size']);
        $response->sendHeaders();
        $response->setContent($stream);
        return $response;
    }

    /**
     * @Route("/files/delete:{fileId}", name="delete_file", options={"expose"=true})
     * @param String $fileId
     * @return JsonResponse
     */
    public function deleteAction(String $fileId)
    {
        $fileBusiness = $this->get('file.business');
        $fileBusiness->deleteFileBusiness($fileId, $this->getUser());
        $fileSystem = $this->get('oneup_flysystem.jarvis_filesystem');
        $fileSystem->delete($fileId);
        return new JsonResponse(array('status' => 'server'));
    }

}
