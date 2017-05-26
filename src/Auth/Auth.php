<?php
/**
 * Created by PhpStorm.
 * User: rubis
 * Date: 20/04/17
 * Time: 14:36
 */

namespace SONFin\Auth;



use SONFin\Models\UserInterface;

class Auth implements AuthInterface
{
    /**
     * @var JasnyAuth
     */
    private $jasnyAuth;


    /**
     * Auth constructor.
     */
    public function __construct(JasnyAuth $jasnyAuth)
    {
        $this->jasnyAuth = $jasnyAuth;
        $this->sessionStar();
    }

    public function login(array $crendentials): bool
    {
        list('email' => $email, 'password' => $password) = $crendentials;
        return $this->jasnyAuth->login($email, $password) !== null;
    }

    public function check(): bool
    {
        return $this->user() !== null;
    }

    public function logout(): void
    {
        $this->jasnyAuth->logout();
    }

    public function user(): ?UserInterface
    {
        return $this->jasnyAuth->user();
    }

    public function hashPassword(string $password): string
    {

        return $this->jasnyAuth->hashPassword($password);
    }

    protected function sessionStar()
    {
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }


}