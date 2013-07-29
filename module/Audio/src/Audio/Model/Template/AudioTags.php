<?php

namespace Audio\Model\Template;

class AudioTags {
    public $id3v1 = null;
    public $id3v2 = null;
    
    public function fillFromFile($filePath){
        $id3tags = new \getID3();
        
        
    }
}
