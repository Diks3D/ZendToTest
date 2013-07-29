<?php

namespace Audio\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Audio\Form\UploadForm;
use Audio\Form\AudioEntryForm;
use Audio\Model\Template\AudioTrack;
 
class UploadController extends AbstractActionController
{
    public function indexAction()
    {
        $tmpStorage = $this->getServiceLocator()->get('Model\TemporyStorage');
        return new ViewModel(array(
            'list' => $tmpStorage->getAll(),
        ));
    }
    
    public function uploadAction()
    {
        $form = new UploadForm();
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $tmpStorage = $this->getServiceLocator()->get('Model\TemporyStorage');
            //$form->setInputFilter($tmpStorage->getInputFilter());
            $post = array_merge_recursive(
                $request->getPost()->toArray(), $request->getFiles()->toArray()
            );
            $form->setData($post);

            if ($form->isValid()) {
                $formData = $form->getData();
                foreach ($formData['files'] as $file) {
                    $tmpStorage->addFile($file);
                }
                return $this->redirect()->toRoute('storage');
            }
        }
        
        return array('form' => $form);
    }
    
    public function approveAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('storage');
        }
        
        $form = new AudioEntryForm();
        $tmpStorage = $this->getServiceLocator()->get('Model\TemporyStorage');
        $tmpEntry = $tmpStorage->getEntry($id);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $collection = $this->getServiceLocator()->get('Model\AudioCollection');
            //$form->setInputFilter($collection->getInputFilter());
            $form->setData($request->getPost());
 
            if ($form->isValid()) {
                $audioEntry = new AudioTrack();
                $audioEntry->fromFormData(array_merge($tmpEntry->toArray(), $form->getData()));
                if($collection->add($audioEntry)){
                    $tmpStorage->deleteEntry($id);
                }
                // Redirect to list of albums
                return $this->redirect()->toRoute('storage');
            } else {
                return array('form' => $form, 'id' => $tmpEntry->id);
            }
        }
        
        $data= array(
            'id' => $tmpEntry->id,
            'filename' => $tmpEntry->filename,
        );
        
        $getID3 = new \getID3();
        $audioInfo = $getID3->analyze($tmpEntry->filepath);
        if(isset($audioInfo['tags'])){
            if(isset($audioInfo['tags']['id3v1'])){
                $id3v1 = $audioInfo['tags']['id3v1'];
                $data['title'] = (isset($id3v1['title'])) ? $id3v1['title'][0] : '';
                $data['artist'] = (isset($id3v1['artist'])) ? $id3v1['artist'][0] : '';
            }
            if(isset($audioInfo['tags']['id3v2'])){
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
            return $this->redirect()->toRoute('storage');
        }
 
        $request = $this->getRequest();
        $tmpStorage = $this->getServiceLocator()->get('Model\TemporyStorage');
        if ($request->isPost()) {
            $del = $request->getPost('delete', 'No');
 
            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $tmpStorage->deleteEntry($id);
            }
 
            // Redirect to list of albums
            return $this->redirect()->toRoute('storage');
        }
 
        return array(
            'id'    => $id,
            'entry' => $tmpStorage->getEntry($id),
        );
    }
    
    public function clearAction()
    {
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $del = $request->getPost('delete', 'No');
            if ($del == 'Yes') {
                $tmpStorage = $this->getServiceLocator()->get('Model\TemporyStorage');
                $tmpStorage->clearAll();
            }
 
            // Redirect to list of albums
            return $this->redirect()->toRoute('storage');
        }
    }
    
}
