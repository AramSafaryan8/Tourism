<?php
declare(strict_types = 1);

namespace Models;

use Models\Dbh;
use Models\Attributes\Extended;
use Models\Attributes\Extension;
use Models\IRetriever;

class User
    extends Dbh
    implements IRetriever
{
    private ?int $id;
    private ?string $email;
    private ?string $username;
    private ?string $pwd;
    protected const TABLENAME = 'users';

    public function __construct (?int $id = NULL, ?string $email = NULL, ?string $username = NULL, ?string $pwd = NULL) {
        $this->id = $id;
        $this->email = $email;
        $this->username = ('' === $username) ? NULL : $username;
        $this->pwd = $pwd;
    }
    
    private function is_invalid_email () : bool {
        return !filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }
    
    private function is_invalid_username () : bool {
        return (!empty($this->username)) && !(false === strpos($this->username, ' '));
    }

    private function has_empty_field () : bool {
        return empty($this->email) || empty($this->pwd);
    }

    private function register () : void {
        $this->verify();

        $this->connect();

        $user = $this->get([
            'email' => [
                'value' => $this->email,
                'type' => \PDO::PARAM_STR
            ]
        ]);

        if (!empty($user)) {
            $this->close();

            redirect('location: ', '/auth/signup?err=duplicate');
        }

        $this->prepare('INSERT INTO `' . self::TABLENAME . '` (`id`, `email`, `username`, `pwd`) VALUES(NULL, :email, :username, :pwd);', [
            'email' => [
                'value' => $this->email,
                'type' => \PDO::PARAM_STR
            ],
            'username' => [
                'value' => $this->username,
                'type' => \PDO::PARAM_STR | \PDO::PARAM_NULL
            ],
            'pwd' => [
                'value' => $this->pwd,
                'type' => \PDO::PARAM_STR
            ]
        ]);
        
        $this->id = (int)$this->query("SELECT `id` FROM `" . self::TABLENAME . "` WHERE `email` = '$this->email';")[0]->id;

        $this->close();
    }

    public static function get_by (array $params) : array {
        $instance = new self();

        return $instance->get($params);
    }

    public static function get_all () : array {
        $instance = new self();

        $instance->connect();
        
        $users = $instance->query('SELECT * FROM `' . self::TABLENAME . '`;');

        $instance->close();

        return $users;
    }

    public static function create (string $email, ?string $username, string $pwd) : User {
        $user = new self(NULL, $email, $username, $pwd);

        $user->register();

        return $user;
    }

    public function get_email () : string {
        return $this->email;
    }

    public function get_id () : int {
        return $this->id;
    }
    
	public function get_keys() : array {		
		return (new \ReflectionClass(self::class))->getProperties(\ReflectionProperty::IS_PRIVATE);
    }

    public function get_pwd () : string {
        return $this->pwd;
    }

    public function get_username () : ?string {
        return $this->username;
    }

    public function retrieve (array $resp) : array {
        if (empty($resp)) {
            return $resp;
        }

        $users = [];
        $key = '';

        $rps = $this->get_keys();
        $rc = new \ReflectionClass($this);
        $arrRA = null;
        $isExtended = false;
        $isExtension = false;

        foreach ($resp as $index => $user) {
            $users[] = new $this();

            foreach ($rps as $rp) {
                $arrRA = $rp->getAttributes();

                foreach ($arrRA as $attribute) {
                    if (Extended::class == $attribute->getName()) {
                        $isExtended = true;

                        break;
                    }

                    if (Extension::class == $attribute->getName()) {
                        $isExtension = true;

                        break;
                    }
                }

                if ($isExtension) {
                    $isExtension = false;

                    continue;
                }

                $key = $rp->name;

                if ($isExtended) {
                    $isExtended = false;
                    $value = $user->$key;
                    $key = 'set_' . $key;

                    $this->$key($value);

                    continue;
                }

                $users[$index]->$key = self::cast($rc->getProperty($key)->getType()->getName(), $user->$key);
            }
        }

        return $users;
    }

    public function verify () : void {
        if ($this->is_invalid_email() || $this->is_invalid_username() || $this->has_empty_field()) {
            redirect('location: ', self::get_referer() . '?err=incorrectdata');
        }
    }
}