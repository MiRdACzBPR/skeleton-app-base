<?php

declare(strict_types=1);

namespace App\Presentation\Sign;

use Nette;
use Nette\Application\UI\Form;
use App\Presentation\BasePresenter;

final class SignPresenter extends BasePresenter
{

    public function __construct(
		private FormFactory $formFactory,private SignFacade $signFacade
	) {
	}
/** registracni */
    public function renderRegister(): Void
    {
    }

    protected function createComponentRegForm(): Form
    {
        $form = $this->formFactory->Register();
        $form->onSuccess[] = function (Form $form,$data){
            $this->signFacade->Register($data);
            $this->flashMessage($this->translator->translate('sign.regSuccess'),'alert-success');
            $this->redirect('this');
        };
        return $form;
    }
/** prihlaseni */
    public function renderLogin(): Void
    {
        if ($this->getUser()->isLoggedIn()) {
            $this->redirect('Admin:default');
        }
    }

    protected function createComponentLoginForm(): Form
	{
        $form = $this->formFactory->Login();
        $form->onSuccess[] = function (Form $form,$data){
            try {
                $this->signFacade->Login($data);
                $this->flashMessage($this->translator->translate('sign.logSuccess'),'alert-success');
                $this->redirect('Admin:default');
            }catch (Nette\Security\AuthenticationException $e) {
                if($e->getMessage() == 'password'){
                    $form['password']->addError($this->translator->translate('sign.errorPas'));
                }else{
                    $form['username']->addError($this->translator->translate('sign.errorUS'));
                }
            }
        };
        return $form;
	}
}