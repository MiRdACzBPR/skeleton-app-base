<?php

declare(strict_types=1);

namespace App\Core;

use Nette\Database\Explorer;
use Nette\Security\Permission;
use Nette\Security\IAuthorizator;
use Nette\Security\Role;
use Nette\Security\Resource;

final class MyAuthorizator extends Permission implements IAuthorizator
{
private bool $initialized = false;

    public function __construct(
		private Explorer $database,
	) {}

    private function initialize(): void
	{
        if ($this->initialized) {
            return;
        }
        $this->initialized = true;

        // Role s dědičností
        $this->addRole('guest');
        $this->addRole('user');
        $this->addRole('admin', 'user');

        // Role z DB
        foreach ($this->database->table('users')->select('DISTINCT role') as $row) {
            $role = $row->role;
            if (!$this->hasRole($role)) {
                $this->addRole($role);
            }
        }

        // Zdroje
        foreach ($this->database->table('permissions')->select('DISTINCT resource') as $row) {
            if (!$this->hasResource($row->resource)) {
                $this->addResource($row->resource);
            }
        }

        // Pravidla
        foreach ($this->database->table('permissions') as $perm) {
            $privilege = $perm->privilege ?: null;
            if ($perm->allowed) {
                $this->allow($perm->role, $perm->resource, $privilege);
            } else {
                $this->deny($perm->role, $perm->resource, $privilege);
            }
        }

        // Pevně dané výjimky
        if (!$this->hasResource('Home')) { $this->addResource('Home'); }
        if (!$this->hasResource('Sign')) { $this->addResource('Sign'); }
        if (!$this->hasResource('Admin')) { $this->addResource('Admin'); }
        $this->allow('guest', 'Home', 'default');$this->allow('guest', 'Sign', 'login');
        $this->allow('user', 'Home', null);$this->allow('user', 'Sign', null);
        $this->allow('admin', 'Admin', null);
    }

    public function isAllowed( \Nette\Security\Role|string|null $role = self::All, \Nette\Security\Resource|string|null $resource = self::All,?string $privilege = self::All): bool
    {
        $this->initialize();
        return parent::isAllowed($role, $resource, $privilege);
    }
}
