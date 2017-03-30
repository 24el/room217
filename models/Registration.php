<?php
namespace app\models;

use yii\base\Model;
use app\models\User;
class Registration extends Model {
    public $login;
    public $password;
    public $email;
    public $name;
    public $lastname;
    public $birthday;
    public $description;
    private $reg_code;
    public function rules(){
        return array(
            [['login', 'password', 'email', 'name', 'lastname', 'birthday'], 'required'],
            ['email', 'email'],
            ['birthday', 'date', 'format' => 'yyyy-M-d'],
            [['login', 'email'] , 'unique', 'targetClass' => 'app\models\User'],
            ['password', 'string', 'length' => [4, 24]],
            [['description'], 'safe'],
        );
    }

    public function sendRegistrationEmail(){
        if(\Yii::$app->mailer->compose()
            ->setTo($this->email)
            ->setFrom('room217@heroku.com')
            ->setSubject('Registration')
            ->setTextBody('Confirm your registration by entering this link http://localhost/basic/web/index.php?r=delivery%2FregistrationConfirm?regCode='.$this->reg_code)
            ->send()){
                return true;
        }
        return false;
    }
    /**
     * Registrion new user.
     * This method serves as user registration with confirm mailer.
     *
     * @return boolean whether the registration form was validated successuly and mail was send.
     */
    public function registrationUser(){
        if($this->validate()){
            $this->reg_code = \Yii::$app->security->generateRandomString(32);
            if($this->sendRegistrationEmail()){
                $user = new \app\models\User();
                $user->login = $this->login;
                $user->setPassword($this->password);
                $user->email = $this->email;
                $user->name = $this->name;
                $user->lastname = $this->lastname;
                $user->birthday = $this->birthday;
                $user->auth_key = \Yii::$app->security->generateRandomString(32);
                $user->reg_code = $this->reg_code;
                $user->registration_date = date('Y-m-d H:i:s');
                $user->save();
                return true;
            }
        return false;
        }
    }

    public function registrationConfirm($regCode){
        $user = User::findOne(['reg_code' => $regCode]);
        if($user->id){
            unset($user->reg_code);
            return true;
        }
        return false;
    }


}