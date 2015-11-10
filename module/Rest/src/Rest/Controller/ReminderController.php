<?php
namespace Rest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Rest\Form\User;
use Rest\Form\ReminderForm;
use Zend\View\Model\JsonModel;

class ReminderController extends AbstractRestfulController
{
    protected $restTable;

    //Takes direct data from Service Manager
    public function getRestTable()
    {
        if (!$this->restTable) {
            $sm = $this->getServiceLocator();
            $this->restTable = $sm->get('Rest\Model\RestTable');

        }
        return $this->restTable;
    }

    //GET request, no data sent
    public function getList()
    {
        $result = new JsonModel(array(
            'Notice' => "Please Choose POST request method and follow the instructions",
            'success' => false,
        ));

        return $result;
    }

    //GET request, data sent
    public function get($id)
    {
        {
            $result = new JsonModel(array(
                'Notice' => "You can't get your password BY ID.Please Choose POST request method and follow the instructions",
                'success' => false,
            ));

            return $result;
        }
    }

    //POST request of Reminder Controller
    public function create($data)
    {
        //if there was no data in POST
        if (!$data) {
            $result = new JsonModel(array(
                'Notice' => "To get your Password on Email please send POST request parameters in the next way:",
                'Line'=>['key' => 'email','value'=>'your_email_name'],
                'success' => false,
            ));
            return $result;
        } else {
            //takes data,sets rules
            $form = new ReminderForm();
            $request = $this->getRequest();
            $user = new User();
            $form->setInputFilter($form->getInputFilter());
            $form->setData($request->getPost());
            //validating
            if ($form->isValid()) {
                $data = $form->getData();
                $user->exchangeArray($data);
                //checking the email
                if(!$password = $this->getRestTable()->getPassword($user)){
                    $result = new JsonModel(array(
                        'Notice'=>'There is no user in DB with this email',
                        'success' => false
                    ));
                    return $result;
                }
                //sending the password
                $result = new JsonModel(array(
                    'userPassword' => $password,
                    'result'=>'This password will be sent to your Email',
                    'success' => true
                ));
                return $result;
            }
        }

        //if data is not Valid
        $result = new JsonModel(array(
            'Message' => 'Incorrect entered data',
            'success' => false,
        ));
        return $result;
    }


}