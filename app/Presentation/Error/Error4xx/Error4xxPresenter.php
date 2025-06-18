<?php
declare(strict_types=1);

namespace App\Presentation\Error\Error4xx;

use Nette;
use Nette\Application\Attributes\Requires;
use Nette\Application\Attributes\Persistent;
use Contributte\Translation\LocalesResolvers\Session;

#[Requires(methods: '*', forward: true)]
final class Error4xxPresenter extends Nette\Application\UI\Presenter
{
    #[Persistent]
    public string $lang;

    /** @var Nette\Localization\ITranslator @inject */
    public $translator;

    /** @var Session @inject */
    public $translatorSessionResolver;

    public function beforeRender(): void
    {
        $this->template->lang = $this->translator->getLocale();
    }

    public function renderDefault(Nette\Application\BadRequestException $exception): void
    {
        $code = $exception->getCode();
        $file = __DIR__ . "/$code.latte";
        $this->template->httpCode = $code;
        $this->template->setFile(is_file($file) ? $file : __DIR__ . '/4xx.latte');
    }
}
