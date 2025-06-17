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

    protected function startup(): void
	{
        parent::startup();
        $this->checkPermissions();
    }

    public function handleChangeLocale(string $locale): void
	{
		$this->translatorSessionResolver->setLocale($locale);
		$this->redirect('this');
	}

    protected function checkPermissions(): void
	{
        $resource = $this->getName();   // např. "User"
        $privilege = $this->getAction(); // např. "edit"

        if (!$this->user->isAllowed($resource, $privilege)) {
            $this->flashMessage($this->translator->translate('Opravneni-ne'), 'alert-danger');
            $this->redirect('Home:default');
        }
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