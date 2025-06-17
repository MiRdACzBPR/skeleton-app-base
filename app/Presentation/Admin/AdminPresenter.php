<?php

declare(strict_types=1);

namespace App\Presentation\Admin;

use App\Presentation\BasePresenter;
use Nette;


final class AdminPresenter extends BasePresenter
{
    public function __construct(private AdminFacade $adminFacade)
    {
	}

    public function renderDefault(): void
	{
        $this->template->dumpAccess = $this->adminFacade->dumpAccess()->fetchAll();
        $this->template->dumpUsers = $this->adminFacade->dumpUsers()->fetchAll();
    }

    public function actionLogOut(): void
    {
        $user = $this->getUser();$user->logout();
        $this->flashMessage($this->translator->translate('sign.logOut'),'alert-success');$this->redirect('this');
    }
}
