<?php

namespace Audio\Model\Template;

class AudioTrack
{
    public $id = null;
    public $filename = null;
    public $filepath = null;
    public $md5_hash = null;
    public $artist = null;
    public $title = null;
    public $tags = null;
    public $created = null;
    public $updated = null;
 
    public function exchangeArray($data)
    {
        foreach($data as $key => $value){
            $this->$key = $value;
        }
    }
    
    public function fromFormData($formData)
    {
        foreach ($this as $key => $value) {
            switch ($key) {
                case 'md5_hash':
                    $this->md5_hash = md5_file($formData['filepath']);
                    break;
                case 'created':
                    if(isset($formData['uploaded'])){
                        $this->created = $formData['uploaded'];
                    }
                    break;
                case 'updated':
                    if(!isset($formData['updated'])){
                        $this->updated = $this->created;
                    }
                    break;
                case 'tags':
                    if(!isset($formData['tags']) || !$formData['tags']){
                        $this->tags = '<?xml version="1.0"?><tags></tags>';
                    }
                    break;
                case 'id':
                case 'filename':
                case 'title':
                case 'artist':
                default:
                    if (isset($formData[$key])) {
                        $this->$key = $formData[$key];
                    }
            }
        }
        return $this;
    }
}
