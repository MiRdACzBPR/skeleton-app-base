<?php

declare(strict_types=1);

namespace App\Presentation\Home;

use App\Presentation\BasePresenter;
use App\Model\PageRepository;
use Nette;


final class HomePresenter extends BasePresenter
{
    public function __construct(
        private PageRepository $pageRepository
    ) {
        parent::__construct();
    }
    public function renderDefault(): void
    {
        $url  = (string) $this->getParameter('url');
        $lang = $this->translator->getLocale();

        if ($url === '') {
            // homepage listing
            $this->template->page = $this->pageRepository->findOneByUrl('home', $lang);
        } else {
            // detail podle slugu
            $page = $this->pageRepository->findOneByUrl((string)$url, $lang);
            if (! $page) {
                $this->error('Stránka nenalezena');
            }
            $this->template->page = $page;
        }
    }
}
