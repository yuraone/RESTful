<?php
namespace Rest\Controller;


use Zend\Mvc\Controller\AbstractRestfulController;
use Rest\Form\User;
use Rest\Form\SignInForm;
use Zend\View\Model\JsonModel;

class SignInController extends AbstractRestfulController
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
        //Default - Database locked, GET request method,no data
        $result = new JsonModel(array(
            'ALL_USERS_DATA' => ['Answer' => "You cannot look through the Information. The Information is locked. Please Sign In"],
            'SignUpController' => "sign-up",
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
            'Notice' => ["To SignIn  please use POST request method"],
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
                'Notice' => "To Sign In please send POST request parameters in the next way:",
                'First Line'=>['key' => 'email','value'=>'your_email_name'],
                'Second Line'=>['key' => 'password','value'=>'your_password_name'],
                'success' => false,
            ));
            return $result;
        } else {
            //taking data
            $form = new SignInForm();
            $request = $this->getRequest();
            $user = new User();
            $form->setInputFilter($form->getInputFilter());
            $form->setData($request->getPost());
            //validating data
            if ($form->isValid()) {
                $data = $form->getData();
                $user->exchangeArray($data);
                //trying to signIn
                if ($userInfo = $this->getRestTable()->signInUser($user)) {
                    $result = new JsonModel(array(
                        'actionSignIn' => 'ok',
                        'success' => true,
                        'UserInfo'=> [$userInfo],
                    ));
                    return $result;
                }else{
                    //Bad try
                    $result = new JsonModel(array(                                                                      //ответ, если пришли некорректные данные
                        'Message' => 'Incorrect Email or Password',
                        'success' => false,
                    ));
                    return $result;
                }
            }
        }
        //data is not valid
        $result = new JsonModel(array(                                                                      //ответ, если пришли некорректные данные
            'Message' => 'Incorrect Entered Data Format',
            'success' => false,
        ));
        return $result;
    }
}