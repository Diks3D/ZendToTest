<?php
namespace Audio\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Audio\Form\AudioEntryForm;
use Audio\Model;

class AudioController extends AbstractActionController
{
    protected $_table;

    public function indexAction()
    {
        return new ViewModel(array(
                'list' => $this->getAudioTable()->getAll(),
            ));
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('storage');
        }

        $form = new AudioEntryForm();
        $collection = $this->getServiceLocator()->get('Model\AudioCollection');
        $entry = $collection->getEntry($id);

        $request = $this->getRequest();
        if ($request->isPost()) {
            //$form->setInputFilter($collection->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $audioEntry = new AudioTrack();
                $audioEntry->fromFormData($form->getData());
                $collection->add($audioEntry);
                
                // Redirect to list of albums
                return $this->redirect()->toRoute('audio');
            } else {
                return array('form' => $form, 'id' => $collection->id);
            }
        }


        $getID3 = new \getID3();
        $audioInfo = $getID3->analyze($entry->filepath);
        var_dump($audioInfo['tags']['id3v2']); exit;
        if (isset($audioInfo['tags'])) {
            if (isset($audioInfo['tags']['id3v1'])) {
                $id3v1 = $audioInfo['tags']['id3v1'];
                $data['title'] = (isset($id3v1['title'])) ? $id3v1['title'][0] : '';
                $data['artist'] = (isset($id3v1['artist'])) ? $id3v1['artist'][0] : '';
            }
            if (isset($audioInfo['tags']['id3v2'])) {
                $id3v2 = $audioInfo['tags']['id3v2'];
                $data['title'] = (isset($id3v2['title'])) ? $id3v2['title'][0] : '';
                $data['artist'] = (isset($id3v2['artist'])) ? $id3v2['artist'][0] : '';
            }
        }

        $form->setData($data);
        return array('form' => $form, 'id' => $tmpEntry->id);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('audio');
        }

        $request = $this->getRequest();
        $collection = $this->getServiceLocator()->get('Model\AudioCollection');
        if ($request->isPost()) {
            $del = $request->getPost('delete', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $collection->deleteEntry($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('audio');
        }

        return array(
            'id' => $id,
            'entry' => $collection->getEntry($id),
        );
    }

    public function getAudioTable()
    {
        if (!$this->_table) {
            $sm = $this->getServiceLocator();
            $this->_table = $sm->get('Model\AudioCollection');
        }
        return $this->_table;
    }

}
