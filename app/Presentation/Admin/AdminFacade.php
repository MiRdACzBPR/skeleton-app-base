<?php

declare(strict_types=1);

namespace App\Presentation\Admin;

use Nette;
use Nette\Utils\Strings;
use Nette\Utils\Random;
use Nette\Security\Passwords;
use Nette\Security\User;

final class AdminFacade

{
    public function __construct(private Nette\Database\Explorer $database,private Passwords $passwords,private User $user,)
    {
    $passwords = new Passwords(PASSWORD_BCRYPT, ['cost' => 12]);
	}

public function dumpAccess()
{
    return $this->database->table('permissions');
}
public function dumpUsers()
{
    return $this->database->table('users');
}

public function Register($values)
{
    $token = Random::generate(18);
    $this->database->beginTransaction();
    try {
        $this->database->table('users')->insert([
            'role' => 'admin',
            'username' => $values->username,
            'email' => $values->email,
            'password' => $this->passwords->hash($values->password),
            'active_key' => null,
            'authtoken' => $token,
            'ip' => $values->ip,
        ]);$this->database->commit();
    } catch (PDOException $e) {
        $this->database->rollBack();
        throw $e;
    }
}

public function Login($data)
{
    $this->user->setExpiration('20 minutes');
    $this->user->login($data->username, $data->password);
}

}