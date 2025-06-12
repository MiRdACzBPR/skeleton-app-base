<?php

declare(strict_types=1);

namespace App\Presentation\Admin;

use App\Presentation\BasePresenter;
use Nette;


final class AdminPresenter extends BasePresenter
{

    protected function startup()
    {
        parent::startup();
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:login');
        }
    }

    public function renderDefault(): void
	{
    }
}
