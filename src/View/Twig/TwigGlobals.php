<?php
/**
 * Created by PhpStorm.
 * User: rubis
 * Date: 20/04/17
 * Time: 16:44
 */

namespace SONFin\View\Twig;


use SONFin\Auth\AuthInterface;

class TwigGlobals extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    /**
     * @var AuthInterface
     */
    private $auth;


    /**
     * TwigGlobals constructor.
     */
    public function __construct(AuthInterface $auth)
    {
        $this->auth = $auth;
    }

    public function getGlobals()
    {
        return[
           'Auth' => $this->auth
        ];
    }

}