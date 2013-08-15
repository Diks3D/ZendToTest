<?php

namespace Audio\Model;

use Zend\Db\TableGateway\TableGateway;

class TemporyStorage
{
    const ROOT_PATH = 'D:/www/Zend2/test';
    protected $_tableGw;
    public $storagePath = 'storage/upload';

    public function __construct(TableGateway $tableGateway) {
        $this->_tableGw = $tableGateway;
    }

    /**
     * Get list of tempory uploaded files
     * 
     * @return (array)
     */
    public function getAll() {
        $list = $this->_tableGw->select();
        return $list;
    }
    
    /**
     * Get count of tempory storaged images
     * 
     * @return (int) $count
     */
    public function countTemporyImages(){
        $count = $this->_tableGw->select()->count();
        return $count;
    }

    
    /**
     * Copy uploaded file to temp storage, and add it information to database
     * 
     * @param (array) $file Uploaded file information
     * @return (int) $imageId or false
     */
    public function addFile($file) {
        $originalName = $file['name'];
        $fileType = $file['type'];

        if ($fileType !== 'audio/mp3') {
            return false;
        }

        if (!file_exists(self::ROOT_PATH . "/public/{$this->storagePath}")) {
            mkdir(self::ROOT_PATH . "/public/{$this->storagePath}", 0777, true);
        }
        $fileName = time() . '_' . md5($originalName) . '.mp3';
        $filePath = self::ROOT_PATH . "/public/{$this->storagePath}/" . $fileName;

        $sqlData = array(
            'filename' => $originalName,
            'filepath' => $fileName,
        );
        if (!$this->_tableGw->insert($sqlData)) {
            return false;
        }

        copy($file['tmp_name'], $filePath);

        $fileId = $this->_tableGw->getLastInsertValue();
        return $fileId;
    }
    /**
     * Get single tempory storage item information
     * 
     * @param (int) $imageId
     * @return (array) $item
     */
    public function getEntry($entryId) {
        $rowset = $this->_tableGw->select(array('id' => (int) $entryId));
        $entry = $rowset->current();
        if (!$entry) {
            throw new \Exception("Could not find entry with id: $entryId");
        }
        return $entry;
    }

    /**
     * Delete current tempory image item from DB and storage
     * 
     * @param (int) $imageId
     * @return (boolean)
     */
    public function deleteEntry($entryId)
    {
        $rowset = $this->_tableGw->select(array('id' => (int) $entryId));
        $entry = $rowset->current();
        if (!$entry) {
            throw new \Exception("Could not find entry with id: $entryId");
        } else {
            if (unlink($entry->filepath)) {
                $this->_tableGw->delete(array('id' => (int) $entry->id));
                return true;
            }
        }
        return false;
    }

    /**
     * Clean tempory storage and dell all items fron DB table
     * 
     * @return (boolean)
     */
    public function clearAll() {
        $list = scandir(self::ROOT_PATH . "/public/{$this->storagePath}");
        foreach ($list as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $filePath = self::ROOT_PATH . "/public/{$this->storagePath}/$file";
            unlink($filePath);
        }
        $this->_tableGw->delete();
    }
}
