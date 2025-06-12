<?php

declare(strict_types=1);

namespace App\Presentation\Sign;

use Nette;
use Nette\Application\UI;
use Nette\Localization\ITranslator;
use Nette\Application\UI\Form;
use Nette\Application\UI\Multiplier;
use Nette\Utils\Strings;
use Contributte\FormsBootstrap\BootstrapForm;

final class FormFactory
{
    public function __construct(private ITranslator $translator)
    {
	}

    public function Register():Form
    {
        BootstrapForm::switchBootstrapVersion(\Contributte\FormsBootstrap\Enums\BootstrapVersion::V5);
        $form = new BootstrapForm;
        $form->renderMode = \Contributte\FormsBootstrap\Enums\RenderMode::VERTICAL_MODE;
        $form->setHtmlAttribute('autocomplete', 'on');
        $form->addProtection($this->translator->translate('sign.addProtection'));
        $form->addText('username', Strings::upper($this->translator->translate('sign.jmeno')))->setRequired($this->translator->translate('sign.reqJmeno'));
        $form->addEmail('email', Strings::upper($this->translator->translate('sign.email')))->setRequired($this->translator->translate('sign.reqEmail'));
        $form->addPassword('password', Strings::upper($this->translator->translate('sign.heslo')))->setRequired($this->translator->translate('sign.reqHeslo'));
        $form->addPassword('passwordAgain', Strings::upper($this->translator->translate('sign.hesloZn')))->setRequired($this->translator->translate('sign.reqHesloZn'));
        $form->addHidden('website')->setDefaultValue(time());
        $factory = new Nette\Http\RequestFactory;
        $httpRequest = $factory->fromGlobals();
        $ip = $httpRequest->getRemoteAddress();
        $form->addHidden('ip')->setDefaultValue($ip);
        $form->addSubmit('send', Strings::upper($this->translator->translate('sign.registrovat')));
        return $form;
    }
    public function Login():Form
    {
        BootstrapForm::switchBootstrapVersion(\Contributte\FormsBootstrap\Enums\BootstrapVersion::V5);
        $form = new BootstrapForm;
        $form->renderMode = \Contributte\FormsBootstrap\Enums\RenderMode::VERTICAL_MODE;
        $form->setHtmlAttribute('autocomplete', 'on');
        $form->addProtection($this->translator->translate('sign.addProtection'));
        $form->addText('username', Strings::upper($this->translator->translate('sign.jmeno')))->setRequired($this->translator->translate('sign.reqJmeno'));
        $form->addPassword('password', Strings::upper($this->translator->translate('sign.heslo')))->setRequired($this->translator->translate('sign.reqHeslo'));
        $form->addSubmit('send', Strings::upper($this->translator->translate('sign.prihlasit')));
        return $form;
    }
}