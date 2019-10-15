<?php
namespace Album\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Album\Model\Album;          
 use Album\Form\AlbumForm; 

 class AlbumController extends AbstractActionController
 {
 	protected $albumTable;
 	
   

    public function indexAction()
    {
         $form = new AlbumForm();
         $form->get('submit')->setValue('Submit');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $album = new Album();
             
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $album->exchangeArray($form->getData());
                 $this->getAlbumTable()->saveAlbum($album);

                 // Redirect to list of albums
                 return $this->url('album', array('action'=>'submited'));
             }
         }
         return array('form' => $form);
    }

    public function submited()
    {
        echo "The Data is Submited";
    }
    
     public function getAlbumTable()
     {
         if (!$this->albumTable) {
             $sm = $this->getServiceLocator();
             $this->albumTable = $sm->get('Album\Model\AlbumTable');
         }
         return $this->albumTable;
     }
 }