<?php

declare(strict_types=1);

namespace App\Presentation\Search;

use App\Presentation\BasePresenter;
use Nette\Forms\Form;
use Nette\Neon\Neon;
use Nette\Utils\Finder;
use Nette\Utils\Strings;
use Contributte\FormsBootstrap\BootstrapForm;
use Contributte\FormsBootstrap\Enums\BootstrapVersion;
use App\Model\ResourceFacade;

final class SearchPresenter extends BasePresenter
{
    /**
     * Dynamically build pages list by scanning template directories
     *
     * @return array<string, string[]>
     */
    public function __construct(
		private ResourceFacade $resourceFacade,
	) {}

public function renderDefault(?string $q = null): void
    {
        $this->template->query   = $q;
        $this->template->results = [];

        if (empty($q)) {
            return;
        }
        $lowerQ = Strings::lower($q);
        $baseDir = __DIR__ . '/../';

        // 1) Search in Latte templates
        foreach ($this->resourceFacade->getResources() as $presenter => $actions) {
            foreach ($actions as $action) {
                $path = __DIR__ . "/../$presenter/$action.latte";
                if (!is_file($path)) {
                    continue;
                }
                $raw   = file_get_contents($path);
                $clean = Strings::replace($raw, '~\{[^}]+\}~');
                $text  = Strings::lower(strip_tags($clean));

                if (($pos = Strings::indexOf($text, $lowerQ)) !== null) {
                    $start   = max(0, $pos - 30);
                    $snippet = Strings::substring($text, $start, 100) . '…';
                    $this->template->results[] = [
                        'type'    => 'page',
                        'link'    => "$presenter:$action",
                        'title'   => "$presenter › $action",
                        'snippet' => $snippet,
                    ];
                }
            }
        }

        // 2) Search in translation files
        $locale = $this->translator->getLocale();
        // a) Presentation locales
        foreach (Finder::findDirectories('locales')->in($baseDir) as $locDir) {
            $presenter = basename(dirname($locDir->getPathname()));
            foreach (Finder::findFiles("*.{$locale}.neon")->in($locDir->getPathname()) as $file) {
                $data = Neon::decode(file_get_contents($file->getPathname()));
                $this->searchTranslationsRecursive($data, '', $lowerQ, $presenter);
            }
        }
        // b) Global translations
        $langDir = dirname(__DIR__, 2) . '/Lang';
        if (is_dir($langDir)) {
            foreach (Finder::findFiles("*.{$locale}.neon")->in($langDir) as $file) {
                // basename bez .neon např. "sign.cs"
                $base = $file->getBasename('.neon');
                [$name, $loc] = explode('.', $base, 2);
                if ($loc !== $locale) {
                    continue;
                }
                $presenter = ucfirst($name);      // "sign" → "Sign"
                $data = Neon::decode(file_get_contents($file->getPathname()));
                $this->searchTranslationsRecursive($data, '', $lowerQ, $presenter);
            }
        }
    }

    /**
     * Recursively search nested translation arrays and build link
     *
     * @param mixed  $data
     * @param string $prefix
     * @param string $lowerQ
     * @param string|null $presenter from which this translation originates
     */
   private function searchTranslationsRecursive($data, string $prefix, string $lowerQ, ?string $presenter): void
{
    if (!is_array($data)) {
        return;
    }
    foreach ($data as $key => $value) {
        $fullKey = $prefix === '' ? $key : "$prefix.$key";
        if (is_array($value)) {
            $this->searchTranslationsRecursive($value, $fullKey, $lowerQ, $presenter);
            continue;
        }
        if (!is_string($value)) {
            continue;
        }
        $lowerVal = Strings::lower($value);
        $pos = strpos($lowerVal, $lowerQ);
        if ($pos === false) {
            continue;
        }
        $start   = max(0, $pos - 30);
        $snippet = Strings::substring($lowerVal, $start, 100) . '…';

        // Vypočteme link
        if ($presenter) {
            $link = '';
            foreach ($this->resourceFacade->getResources()[$presenter] as $action) {
                $tpl = __DIR__ . "/../$presenter/$action.latte";
                $content = is_file($tpl) ? file_get_contents($tpl) : '';
                if (strpos($content, "{_{$presenter}.{$key}}") !== false) {
                    $link = "$presenter:$action";
                    break;
                }
            }
            if (!$link) {
                $link = "$presenter:default";
            }
        } else {
            // Globální překlad – směrujeme na Home:default
            $link = 'Home:default';
        }

        $this->template->results[] = [
            'type'    => 'translation',
            'key'     => $fullKey,
            'value'   => $value,
            'snippet' => $snippet,
            'link'    => $link,
            'title'   => $value,
        ];
    }
}


    protected function createComponentSearchForm(): Form
    {
        BootstrapForm::switchBootstrapVersion(BootstrapVersion::V5);
        $form = new BootstrapForm;
        $form->addText('q');
        $form->addSubmit('send', 'Hledat');
        $form->onSuccess[] = function (Form $form, \stdClass $values): void {
        $this->redirect('this', ['q' => $values->q]);
    };
        return $form;
    }
}
