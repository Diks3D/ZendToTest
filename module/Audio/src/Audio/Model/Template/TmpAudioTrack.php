<?php

namespace Audio\Model\Template;

class TmpAudioTrack
{
    public $id = null;
    public $filename = null;
    public $filepath = null;
    public $uploaded = null;
    public $source = null;
    
    const ROOT_PATH = 'D:/www/Zend2/test';
    protected $_storagePath = 'upload_storage';
 
    public function exchangeArray($row)
    {
        $this->id = $row['id'];
        $this->filename = $row['filename'];
        $this->filepath = self::ROOT_PATH . "/public/{$this->_storagePath}/" . $row['filepath'];
        $this->uploaded = $row['uploaded'];
        $this->source = "/{$this->_storagePath}/" . $row['filepath'];
    }
    
    public function toArray(){
        return  get_object_vars($this);
    }
}
