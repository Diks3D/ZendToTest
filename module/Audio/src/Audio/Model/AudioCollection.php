<?php
namespace Audio\Model;

use Zend\Db\TableGateway\TableGateway;

class AudioCollection
{
    const ROOT_PATH = 'D:/www/Zend2/test';

    protected $_storagePath = 'storage/audio';
    protected $_tableGw;

    public function __construct(TableGateway $tableGateway)
    {
        $this->_tableGw = $tableGateway;
    }

    public function getAll()
    {
        $resultSet = $this->_tableGw->select();
        return $resultSet;
    }

    public function getEntry($id)
    {
        $id = (int) $id;
        $rowset = $this->_tableGw->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function add(Template\AudioTrack $audioEntry)
    {
        //Prepare db data
        $data = array(
            'artist' => $audioEntry->artist,
            'title' => $audioEntry->title,
            'filename' => $audioEntry->filename,
            'filepath' => $audioEntry->filepath,
            'md5_hash' => $audioEntry->md5_hash,
            'tags' => $audioEntry->tags,
            'updated' => date('Y-m-d H:i:s'),
        );
        if ($audioEntry->artist && $audioEntry->title) {
            $destinationDir = self::ROOT_PATH . "/public/{$this->_storagePath}/{$audioEntry->artist}";
            if (!file_exists($destinationDir)) {
                mkdir($destinationDir, 0777, true);
            }
            $fileName = md5_file($audioEntry->filepath) . '.mp3';
            $destinationPath = "{$destinationDir}/{$fileName}";
            copy($audioEntry->filepath, $destinationPath);
        } else {
            $destinationDir = self::ROOT_PATH . "/public/{$this->_storagePath}/unsorted";
            if (!file_exists($destinationDir)) {
                mkdir($destinationDir, 0777, true);
            }
            $fileName = md5_file($audioEntry->filepath) . '.mp3';
            $destinationPath = "{$destinationDir}/{$fileName}";
            copy($audioEntry->filepath, $destinationPath);
        }
        $data['filepath'] = $destinationPath;

        $this->_tableGw->insert($data);
        
        return $this->_tableGw->getLastInsertValue();
    }

    public function update(Template\AudioTrack $audioEntry)
    {
        var_dump(dirname($audioEntry->filepath));
        exit;
        $data = array(
            'artist' => $audioEntry->artist,
            'title' => $audioEntry->title,
            'filename' => $audioEntry->filename,
            'filepath' => $audioEntry->filepath,
            'md5_hash' => $audioEntry->md5_hash,
            'tags' => $audioEntry->tags,
            'updated' => date('Y-m-d H:i:s'),
        );
        $id = (int) $audioEntry->id;
        if ($id == 0) {
            $this->_tableGw->insert($data);
        } else {
            $this->getEntry($id);
            $this->_tableGw->update($data, array('id' => $id));
        }
    }

    public function delete($id)
    {
        $this->_tableGw->delete(array('id' => $id));
    }

}
