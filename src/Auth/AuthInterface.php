<?php
/**
 * Created by PhpStorm.
 * User: rubis
 * Date: 20/04/17
 * Time: 12:41
 */

declare(strict_types=1);
namespace SONFin\Auth;


use SONFin\Models\UserInterface;

interface AuthInterface
{

    public function login(array $crendentials): bool;

    public function check(): bool;

    public function logout(): void;

    public function hashPassword(string $password): string;

    public function user(): ?UserInterface;


}