<?php
namespace Tests\AppBundle\Utils;

use AppBundle\Entity\Folder;
use AppBundle\Utils\WebixFormatter;
use DateTime;

/**
 * Created by PhpStorm.
 * User: adelise
 * Date: 18/10/2016
 * Time: 12:04
 */
class WebixFormatterTest extends \PHPUnit_Framework_TestCase
{

    public function testRootFolderFormatWithNoFolders()
    {
        $rootFolder = $this->_createFolderMock('TOTO');

        $formatter = new WebixFormatter();
        $webixArray = $formatter->formatRootFolder($rootFolder);

        $expectedFormatArray = [
            'id' => 'root',
            'value' => 'TOTO',
            'type' => 'folder',
            'size' => 0,
            'date' => 0,
            'open' => true,
            'data' => array(),
        ];

        $this->assertEquals($expectedFormatArray, $webixArray);
    }

    public function testRootFolderFormatWithRootFolderProperties()
    {
        $rootFolder = $this->_createFolderMock('TOTO');

        $formatter = new WebixFormatter();
        $webixArray = $formatter->formatRootFolder($rootFolder);

        $expectedFormatArray = [
            'id' => 'root',
            'value' => 'TOTO',
            'type' => 'folder',
            'size' => 0,
            'date' => 0,
            'open' => true,
            'data' => array(),
        ];

        $this->assertEquals($expectedFormatArray, $webixArray);
    }

    public function testFormatOneFolder()
    {
        $expectedDate = new DateTime('2015-12-12 00:00:00');
        $folder = $this->_createFolderMock('firstFolder');
        $folder->expects($this->once())->method('getId')->will($this->returnValue(1));
        $folder->expects($this->once())->method('getCreationDate')->will($this->returnValue($expectedDate));

        $formatter = new WebixFormatter();
        $webixArray = $formatter->formatFolders(array($folder));

        $expectedFormatArray = [
            'id' => 1,
            'value' => 'firstFolder',
            'type' => 'folder',
            'size' => 0,
            'date' => $expectedDate->getTimestamp(),
            'webix_files' => 1
        ];

        $this->assertEquals(array($expectedFormatArray), $webixArray);
    }

    public function testFormatMultipleFolders()
    {
        $expectedDate = new DateTime('2015-12-12 00:00:00');
        $folder = $this->_createFolderMock('firstFolder');
        $folder->expects($this->once())->method('getId')->will($this->returnValue(1));
        $folder->expects($this->once())->method('getCreationDate')->will($this->returnValue($expectedDate));

        $folder2 = $this->_createFolderMock('secondFolder');
        $folder2->expects($this->once())->method('getId')->will($this->returnValue(2));
        $folder2->expects($this->once())->method('getCreationDate')->will($this->returnValue($expectedDate));

        $folders = array($folder, $folder2);

        $formatter = new WebixFormatter();
        $webixArray = $formatter->formatFolders($folders);

        $expectedFormatArray = array(
            array(
                'id' => 1,
                'value' => 'firstFolder',
                'type' => 'folder',
                'size' => 0,
                'date' => $expectedDate->getTimestamp(),
                'webix_files' => 1
            ),
            array(
                'id' => 2,
                'value' => 'secondFolder',
                'type' => 'folder',
                'size' => 0,
                'date' => $expectedDate->getTimestamp(),
                'webix_files' => 1
            )
        );

        $this->assertEquals($expectedFormatArray, $webixArray);
    }

    public function testFormatRootAndSubfolders()
    {
        $expectedDate = new DateTime('2015-12-12 00:00:00');

        $rootFolder = $this->_createFolderMock('rootFolder');
        $folders = array(
            $this->_createFolderMock('folder1', 1, $expectedDate),
            $this->_createFolderMock('folder2', 2, $expectedDate)
        );
        $expectedFormatArray = array(
            array(
                'id' => 'root',
                'value' => 'rootFolder',
                'type' => 'folder',
                'size' => 0,
                'date' => 0,
                'open' => true,
                'data' => array(
                    array(
                        'id' => 1,
                        'value' => 'folder1',
                        'type' => 'folder',
                        'size' => 0,
                        'date' => $expectedDate->getTimestamp(),
                        'webix_files' => 1
                    ),
                    array(
                        'id' => 2,
                        'value' => 'folder2',
                        'type' => 'folder',
                        'size' => 0,
                        'date' => $expectedDate->getTimestamp(),
                        'webix_files' => 1
                    )
                ),
            )
        );

        $formatter = new WebixFormatter();
        $webixArray = $formatter->format($rootFolder, $folders);

        $this->assertEquals($expectedFormatArray, $webixArray);
    }

    private function _createFolderMock($name, $id = null, DateTime $creationDate = null)
    {
        $folderMock = $this->getMock(Folder::class);
        $folderMock->expects($this->once())->method('getName')->will($this->returnValue($name));
        if ($id) {
            $folderMock->expects($this->once())->method('getId')->will($this->returnValue($id));
        }
        if ($creationDate) {
            $folderMock->expects($this->once())->method('getCreationDate')->will($this->returnValue($creationDate));
        }

        return $folderMock;
    }

}