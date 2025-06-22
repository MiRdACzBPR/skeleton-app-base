<?php
declare(strict_types=1);

namespace App\Model;

use Nette\Caching\Cache;
use Nette\Caching\IStorage;
use Nette\Database\Explorer;
use Nette\Database\Row;
use Nette\Database\Table\ActiveRow;
use Nette\Utils\ArrayHash;

class PageRepository
{
private Explorer $db;
private Cache $cache;

    public function __construct(Explorer $db, IStorage $storage)
    {
        $this->db    = $db;
        $this->cache = new Cache($storage, 'page_repo');
    }

    /**
     * @return ArrayHash{ id: int, url: string, title: string, content: string }|null
     */
    public function findOneByUrl(string $url, string $lang): ?ArrayHash
    {
        $key = ['findOneByUrl', $url, $lang];

        $data = $this->cache->load($key, function (&$dp) use ($url, $lang) {
            $dp[Cache::EXPIRE] = '10 minutes';

            $row = $this->db
                ->table('page_translation')
                ->select('page.id AS id, page.url AS url, page_translation.title AS title, page_translation.content AS content')
                ->joinWhere('page', 'page.id = page_translation.page_id')
                ->where('page_translation.lang = ?', $lang)
                ->where('page.url = ?', $url)
                ->limit(1)
                ->fetch();

            if (! $row) {
                return null;
            }

            // Vrátíme čisté pole s aliasovanými klíči
            return [
                'id'      => $row->id,
                'url'     => $row->url,
                'title'   => $row->title,
                'content' => $row->content,
            ];
        });

        if ($data === null) {
            return null;
        }

        // Přetvoříme pole na ArrayHash, aby Latte našlo ->title, ->content atd.
        return ArrayHash::from($data);
    }

}
