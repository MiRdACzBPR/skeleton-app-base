<?php

declare(strict_types=1);

namespace App\Core;

use Nette\Database\Explorer;
use Nette\Security\Permission;
use Nette\Security\IAuthorizator;
use Nette\Caching\Cache;
use Nette\Caching\Storage;
use App\Model\ResourceFacade;

final class MyAuthorizator extends Permission implements IAuthorizator
{
private bool $initialized = false;
private Cache $cache;

    public function __construct(
        private Explorer $database,
        private ResourceFacade $resourceFacade,
        Storage $storage
    ) {
        $this->cache = new Cache($storage, 'authorizator');
    }

private function initialize(): void
    {
        if ($this->initialized) {
            return;
        }
        $this->initialized = true;

        // 1) Statické role
        $this->addRole('guest');
        $this->addRole('user');
        $this->addRole('admin', 'user');

        // 2) Dynamické role z DB
        $roles = $this->database
            ->table('users')
            ->select('DISTINCT role')
            ->fetchPairs('role', 'role');
        foreach ($roles as $role) {
            if (!$this->hasRole($role)) {   // ← kontrola, aby 'admin' či jiné statické role nebyly přidány podruhé
                $this->addRole($role);
            }
        }

        // 3) Dynamické resources z fasády
        $resources = array_keys($this->resourceFacade->getResources());
        foreach ($resources as $res) {
            $this->addResource($res);
        }

        // 4) Načteme permissions z cache nebo DB jako čisté pole
        $perms = $this->cache->load('permissions', function (&$deps) {
            // expire za 5 minut
            $deps[Cache::EXPIRE] = '300 seconds';
            return $this->database
                ->query('SELECT role, resource, privilege, allowed FROM permissions')
                ->fetchAll(\PDO::FETCH_ASSOC);
        });

        // 5) Aplikace DB pravidel (allow/deny má nejvyšší prioritu)
        $hasRule = [];
        foreach ($perms as $perm) {
            $role     = $perm['role'];
            $resource = $perm['resource'];
            $priv     = $perm['privilege'] !== null ? $perm['privilege'] : self::ALL;
            $hasRule[$role][$resource] = true;
            if ($perm['allowed']) {
                $this->allow($role, $resource, $priv);
            } else {
                $this->deny($role, $resource, $priv);
            }
        }

        // 6) Defaultní allow pro guest/user na všechny resources (kromě Admin),
        //    ale pouze pokud tam není žádné DB pravidlo
        foreach ($resources as $res) {
            if ($res === 'Admin') {
                continue;
            }
            if (empty($hasRule['guest'][$res])) {
                $this->allow('guest', $res, self::ALL);
            }
            if (empty($hasRule['user'][$res])) {
                $this->allow('user', $res, self::ALL);
            }
        }
    }

    public function isAllowed(
    \Nette\Security\Role|string|null     $role      = self::ALL,
        \Nette\Security\Resource|string|null $resource  = self::ALL,
        ?string                              $privilege = self::ALL
    ): bool {
        $this->initialize();
        return parent::isAllowed($role, $resource, $privilege);
    }
}
