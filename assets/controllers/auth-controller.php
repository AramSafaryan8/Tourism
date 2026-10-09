<?php
declare(strict_types = 1);

namespace Controllers;

use AppData\Config;
use Scripts\EErrors;
use Models\User;
use Rendering\View;

class Auth
{
    private static $user;

    public static function index (array $request) {
        return self::is_authed() ? '' : self::signin_index($request);
    }

    private static function handle_error(array $request) {
        $errComponent = '';

        if (isset($request['err']) && ($err = EErrors::get($request['err']))) {
            $errComponent = new View('/error.phtml', ['{{@err-title}}' => $err['title'], '{{@err-msg}}' => $err['msg']]);
        }

        return $errComponent;
    }

    private static function set_credentials () : void {
        $_SESSION['token'] = hash('sha256', uniqid());

        $_SESSION['userId'] = self::$user->get_id();
        $_SESSION['email'] = self::$user->get_email();
        $_SESSION['username'] = self::$user->get_username();
    }

    private static function signin_component (array $request = []) : View {
        return new View('/auth.phtml', [
            '{{@auth-action}}' => 'signin',
            '{{@auth-title}}' => 'Sign In',
            '{{@auth-redirect-path}}' => 'signup',
            '{{@auth-redirect-msg}}' => 'Don\'t have an account',
            '{{@err}}' => self::handle_error($request)
        ]);
    }
    
    private static function signup_component (array $request) : View {
        return new View('/auth.phtml', [
            '{{@auth-action}}' => 'signup',
            '{{@auth-title}}' => 'Sign Up',
            '{{@auth-field-inmiddle}}' => new View('/auth/signup.phtml'),
            '{{@auth-redirect-path}}' => 'signin',
            '{{@auth-redirect-msg}}' => 'Already have an account',
            '{{@err}}' => self::handle_error($request)
        ]);
    }

    public static function is_authed () : bool {
        return isset($_SESSION['token']);
    }

    public static function signin_index (array $request) : View {
        if (self::is_authed()) {
            redirect('location: ', '/');
        }

        return (new View('/main_template.phtml', [
            '{{@title}}' => 'Sign in',
            '{{@links}}' => '<link rel="stylesheet" href="' . Config::get_dirs()->webRoot . '/public/styles/auth.css" />',
            '{{@content}}' => self::signin_component($request)
        ]));
    }

    public static function signin (array $request) : void {
        if (self::is_authed()) {
            redirect('location: ', '/');
        }

        self::$user = new User(NULL, $request['Email'], NULL, $request['Pwd']);
        
        self::$user->verify();

        self::$user = User::get_by([
            'email' => [
                'value' => self::$user->get_email(),
                'type' => \PDO::PARAM_STR
            ]
        ]);

        if (empty(self::$user)) {
            redirect('location: ', '/auth/signin?err=incorrectdata');
        }

        self::$user = self::$user[0];

        if (!password_verify($request['Pwd'], self::$user->get_pwd())) {
            redirect('location: ', '/auth/signin?err=incorrectdata');
        }
        
        self::set_credentials();

        redirect('location: ', '/');
    }

    public static function signout (array $request) : void {
        if (self::is_authed()) {
            session_unset();
            session_destroy();
        }

        redirect('location: ', '/');
    }
    
    public static function signup (array $request) : void {
        if (self::is_authed()) {
            redirect('location: ', '/');
        }

        self::$user = User::create($request['Email'], $request['Username'], password_hash($request['Pwd'], PASSWORD_BCRYPT));

        self::set_credentials();

        redirect('location: ', '/');
    }

    public static function signup_index (array $request) : View {
        if (self::is_authed()) {
            redirect('location: ', '/');
        }

        return (new View('/main_template.phtml', [
            '{{@title}}' => 'Sign up',
            '{{@links}}' => '<link rel="stylesheet" href="' . Config::get_dirs()->webRoot . '/public/styles/auth.css" />',
            '{{@content}}' => self::signup_component($request)
        ]));
    }
}