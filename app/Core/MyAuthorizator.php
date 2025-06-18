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

        // 1) Statické role s dědičností
        $this->addRole('guest');
        $this->addRole('user');
        $this->addRole('admin', 'user');

        // 2) Dynamické role z DB
        $roles = $this->database
            ->table('users')
            ->select('DISTINCT role')
            ->fetchPairs('role', 'role');
        foreach ($roles as $role) {
            if (!$this->hasRole($role)) {
                $this->addRole($role);
            }
        }

        // 3) Přidej hned na začátku všechny statické resource
        foreach (['Home', 'Sign', 'Admin','Search'] as $static) {
            if (!$this->hasResource($static)) {
                $this->addResource($static);
            }
        }

        // 4) Načti permissions a v jednom průchodu:
        //    – přidej nový resource, když ho potkáš poprvé
        //    – hned aplikuj allow/deny
        $seenResources = [];
        $selection = $this->database
            ->table('permissions')
            ->select('role, resource, privilege, allowed');

        foreach ($selection as $perm) {
            $res = $perm->resource;

            // přidej dynamický resource jen jednou
            if (!isset($seenResources[$res])) {
                $seenResources[$res] = true;
                if (!$this->hasResource($res)) {
                    $this->addResource($res);
                }
            }

            $priv = $perm->privilege ?: null;
            if ($perm->allowed) {
                $this->allow( $perm->role, $res, $priv );
            } else {
                $this->deny( $perm->role, $res, $priv );
            }
        }

        // 5) Pevná pravidla pro základní access
        $this->allow('guest', 'Search',null);
        $this->allow('guest', 'Home',  'default');
        $this->allow('guest', 'Sign',  'login');
        $this->allow('user',  'Home');
        $this->allow('user',  'Search',null);
        $this->allow('user',  'Sign');
        $this->allow('admin', 'Admin');
    }




    public function isAllowed( \Nette\Security\Role|string|null $role = self::All, \Nette\Security\Resource|string|null $resource = self::All,?string $privilege = self::All): bool
    {
        $this->initialize();
        return parent::isAllowed($role, $resource, $privilege);
    }
}
