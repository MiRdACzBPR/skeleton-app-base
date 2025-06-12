<?php declare(strict_types = 1);

namespace App\Presentation;

use Nette;
use Contributte;
use Nette\Application\Attributes\Persistent;
use Nette\Http\Session;
use Nette\Security\User;


class BasePresenter extends Nette\Application\UI\Presenter
{

    #[Persistent]
    public string $locale = '';

    /** @var Nette\Localization\ITranslator @inject */
    public $translator;

    /** @var Contributte\Translation\LocalesResolvers\Session @inject */
    public $translatorSessionResolver;


    public function handleChangeLocale(string $locale): void
	{
		$this->translatorSessionResolver->setLocale($locale);
		$this->redirect('this');
	}
    public function handleLogOut(): void
    {
        $user = $this->getUser();
        $user->logout();
        $this->flashMessage($this->translator->translate('sign.logOut'),'alert-success');
        $this->redirect('this');
    }
    public function beforeRender(): void
    {
      $this->template->lang = $this->translator->getLocale();
    }
    public function renderDefault(): void
	{
        $this->translator->translate('domain.message');
        $prefixedTranslator = $this->translator->createPrefixedTranslator('domain');
        $prefixedTranslator->translate('message');
    }

}