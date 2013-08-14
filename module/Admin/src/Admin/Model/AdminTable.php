<?php

namespace Admin\Model;
 
use Zend\Db\TableGateway\TableGateway,
    Zend\Db\Sql\Select;
 
class AdminTable
{
    protected $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
 
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
 
    public function getById($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    
    public function getByLogin($login)
    {
        $login  = (string) $login;
        $rowset = $this->tableGateway->select(array('login' => $login));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $login");
        }
        return $row;
    }
    
    public function getByEmail($email)
    {
        $email  = (string) $email;
        $rowset = $this->tableGateway->select(array('email' => $email));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $email");
        }
        return $row;
    }
 
    public function addAdmin(\Admin\Model\Admin $admin)
    {
        var_dump($admin); exit;
        $data = array(
            'artist' => $album->artist,
            'title'  => $album->title,
        );
 
        $id = (int)$album->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAlbum($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
 
    public function deleteAlbum($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
    
    public function searchAlbum($needle)
    {
        $resultSet = $this->tableGateway->select(function (Select $select) use ($needle) {
                $select->where->like('title', "%{$needle}%")
                    ->or
                    ->like('artist', "%{$needle}%");
            });
        return $resultSet;
    }

}