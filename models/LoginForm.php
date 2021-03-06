<?php

namespace app\models;

use app\helpers\Access;
use function is_object;
use function var_dump;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $login;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // nick|email and password are both required
            [['login', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'login' => 'Nick/Email',
            'password' => 'Contraseña',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Busca usuarios por [[nick]] o en su defecto por [[email]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = UsuariosDatos::findOne([
                'nick' => $this->login
            ]);

            if (! isset($this->_user)) {
                $this->_user = UsuariosDatos::findOne([
                    'email' => $this->login
                ]);
            }
        }

        /*
         * Cuando _user es un objeto comprueba si está bloqueado el usuario
         * para redireccionar a la vista "userlocked"
         */
        if (is_object($this->_user) && ($this->_user->usuarioBloqueado)) {
            Yii::$app->getResponse()
                ->redirect(['site/userlocked'])
                ->send();
        }

        if (is_object($this->_user) && ($this->_user->id == 2)) {
            Yii::$app->getResponse()
                ->redirect(['site/userlocked'])
                ->send();
        }

        return $this->_user;
    }
}
