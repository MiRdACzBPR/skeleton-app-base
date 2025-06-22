<?php

declare(strict_types=1);

namespace App\Model;

use Nette\Utils\Finder;
use Nette\Caching\Cache;
use Nette\Caching\Storage;

final class ResourceFacade
{
private Cache $cache;

    public function __construct(
        private string $presentationDir,
        Storage $storage
    ) {
        $this->cache = new Cache($storage, 'resourceFacade');
    }

public function getResources(): array
    {
        return $this->cache->load('resources', function (&$dependencies): array {
        $dependencies[Cache::FILES] = $this->presentationDir;

        $resources = [];

        foreach (Finder::findDirectories('*')->in($this->presentationDir) as $dir) {
            $presenterName = $dir->getBasename();
            $actions = [];

            foreach (Finder::findFiles('*.latte')->in($dir->getPathname()) as $file) {
                $actions[] = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            }

            if ($actions) {
                $resources[$presenterName] = $actions;
            }
        }

        return $resources;
    });
    }
}
