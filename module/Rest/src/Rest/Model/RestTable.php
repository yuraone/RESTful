<?php
namespace Rest\Model;

use Rest\Form\User;
use Zend\Db\TableGateway\TableGateway;

class RestTable
{
    protected $tableGateway;
    protected $encryptionKey = "#%!@*&";

    //construct
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    //Takes password from DB
    public function getPassword(User $user){
        $encryptedEmail = $this->encrypt($user->email, $this->encryptionKey);
        if(!$row = $this->checkUser($encryptedEmail))
            return false;
        $pass = trim($this->decrypt($row->password, $this->encryptionKey));
       return $pass;
    }

    //Checks if there is a user in DB with this email
    public function checkUser($email)
    {
        $rowset = $this->tableGateway->select(array('email' => $email));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }

    //User SignUp
    public function saveUser(User $user)
    {
        $encryptedPassword = $this->encrypt($user->password, $this->encryptionKey);
        $encryptedEmail = $this->encrypt($user->email, $this->encryptionKey);
        $encryptedAge = $this->encrypt($user->email, $this->encryptionKey);
        $data = array(
            'email' => $encryptedEmail,
            'password'  => $encryptedPassword,
            'age'  => $encryptedAge,
        );
        if($this->checkUser($data['email'])){
            return false;
        }
        try {
            $this->tableGateway->insert($data);
        }
        catch (\Exception $ex) {
            return false;
        }
        return true;
    }

    //User SignIn
    public function signInUser(User $user)
    {
        $encryptedEmail = $this->encrypt($user->email, $this->encryptionKey);

        $rowset = $this->tableGateway->select(array('email' => $encryptedEmail));
        $row = $rowset->current();
        if (!$row) {
            return false;
        } else {
            $decryptedPassword = trim($this->decrypt($row->password, $this->encryptionKey));
            $decryptedEmail = trim($this->decrypt($row->email, $this->encryptionKey));
            $decryptedAge = trim($this->decrypt($row->age, $this->encryptionKey));
            if ($decryptedPassword == $user->password) {
                $userInfo = array(
                    'email'=>$decryptedEmail,
                    'password'=>$decryptedPassword,
                    'age'=>$decryptedAge);
                return $userInfo;
            } else
                return false;
        }
    }

    //Data Encrypt
    public function encrypt($pure_string,$encryption_key) {
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
        return $encrypted_string;
    }

    //Data Decrypt
    function decrypt($encrypted_string, $encryption_key) {
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
        return $decrypted_string;
    }

}