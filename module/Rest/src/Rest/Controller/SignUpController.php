<?php
namespace Rest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Rest\Form\User;
use Rest\Form\SignUpForm;
use Zend\View\Model\JsonModel;

class SignUpController extends AbstractRestfulController
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

    public function getList()
    {
        // GET request method,no data
        $result = new JsonModel(array(
            'Answer' => "Please Sign up to became a new User",
            'Notice' => "Choose the right Controller to SignIn",
            'SignInController' => "sign-in",
            'SignInAction' => "POST method in SignInController",
            'SignUpAction' => "POST method in SignUpController",
            'success' => false,
        ));

        return $result;
    }

    //GET request method,with data
    public function get($id)
    {
        $result = new JsonModel(array(
            'Notice' => 'To SignUp please choose POST request method and follow the instructions',
            'success' => false,
        ));

        return $result;

    }

    //POST request method
    public function create($data)
    {
        //no data
        if (!$data) {
            $result = new JsonModel(array(
                'Notice' => "To Create a new user please send POST request parameters in the next way:",
                'First Line'=>['key' => 'email','value'=>'your_email_name'],
                'Second Line'=>['key' => 'password','value'=>'your_password_name'],
                'Third Line'=>['key' => 'age','value'=>'your_age'],
                'success' => false,
            ));
            return $result;
        } else {
            //taking data
            $form = new SignUpForm();
            $request = $this->getRequest();
            $user = new User();
            $form->setInputFilter($form->getInputFilter());
            $form->setData($request->getPost());
            //validating data
            if ($form->isValid()) {
                $data = $form->getData();
                $user->exchangeArray($data);
                //trying to signUp,saving to DB
                if($this->getRestTable()->saveUser($user)) {
                    $result = new JsonModel(array(
                        'actionCreate' => 'ok',
                        'success' => true,
                    ));
                    return $result;
                }
            }
        }
        //data is not valid
        $result = new JsonModel(array(
            'Message' => 'Incorrect Entered Data Format or User has already existed',
            'success' => false,
        ));
        return $result;
    }


}