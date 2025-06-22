<?php

declare(strict_types=1);

namespace App\Core;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
        // 1) Hlavní routa: /<presenter>/<action>[/<id>]
        $router->addRoute(
            '[<locale=cs cs|en>/]<presenter>/<action>[/<url>]',
            'Home:default'
        );

        // 2) Fallback pro všechny ostatní neexistující presenters
        $router->addRoute(
            '[<locale=cs cs|en>/]<presenter>[/<action>[/<id><q>]]',
            'Error4xx:default'
        );
		return $router;
	}
}
