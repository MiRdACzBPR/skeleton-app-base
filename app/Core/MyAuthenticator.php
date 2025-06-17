<?php

declare(strict_types=1);

namespace App\Core;

use Nette;
use Nette\Security\SimpleIdentity;
use Nette\Security\IIdentity;

class MyAuthenticator implements Nette\Security\Authenticator, Nette\Security\IdentityHandler
{
    public function __construct(
		private Nette\Database\Explorer $database,
		private Nette\Security\Passwords $passwords,
	) {
	}

    public function authenticate(string $username, string $password): SimpleIdentity
	{
        $row = $this->database->table('users')
            ->where('username', $username)
            ->fetch();

        if (!$row) {
            throw new Nette\Security\AuthenticationException('username');
        }

        if (!$this->passwords->verify($password, $row->password)) {
            throw new Nette\Security\AuthenticationException('password');
        }

        return new SimpleIdentity(
            $row->id,
            $row->role, // nebo pole více rolí
            ['name' => $row->username],
		);
    }

    public function sleepIdentity(IIdentity $identity): SimpleIdentity
	{
        // vrátíme zástupnou identitu, kde v ID bude authtoken
        $u = $identity->getId();
        $identity = $this->database->table('users')
            ->where('id',$u)
            ->fetch();
        return new SimpleIdentity($identity->authtoken);
    }

	public function wakeupIdentity(IIdentity $identity): ?SimpleIdentity
	{
        // zástupnou identitu nahradíme plnou identitou, jako v authenticate()
        $row = $this->database->table('users')->where('authtoken',$identity->getId())->fetch();
        return $row
            ? new SimpleIdentity($row->id, $row->role, ['role' => $row->role,'name' => $row->username])
            : null;
    }
}