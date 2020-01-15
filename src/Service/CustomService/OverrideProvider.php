<?php

namespace App\Service\CustomService;

use App\Entity\User;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;

class OverrideProvider
{
    private const DYNAMIC_DOMAIN = 'dynamic';
    private const TRANSLATE_USER_TEMPLATE = '/U%USER_ID%/translations/%DOMAIN%.%LOCALE%.yaml';
    private const ASSETS_USER_TEMPLATE = '/U%USER_ID%/assets/%FILENAME%.%EXTENSION%';
    private const SERVICE_USER_NAMESPACE = 'App\Custom\U%USER_ID%\Service\Custom%CLASS_NAME%';

    private $pathCustomDir;
    private $locale = 'en_GB';
    private $translator;

    public function __construct(
        string $pathCustomDir,
        RequestStack $requestStack,
        TranslatorInterface $translator
    ) {
        $this->pathCustomDir = $pathCustomDir;
        if ($requestStack->getCurrentRequest()) {
            $this->locale = $requestStack->getCurrentRequest()->getLocale();
        }
        $this->translator = $translator;
    }

    public function addCustomTransResource(
        int $userId,
        string $domain = 'messages'
    ): void {
        $filename = $this->buildFileName(self::TRANSLATE_USER_TEMPLATE, [
            '%USER_ID%' => $userId,
            '%DOMAIN%' => $domain,
            '%LOCALE%' => $this->locale,
        ]);
        if (file_exists($filename)) {
            $this->translator->addResource('yaml', $filename, $this->locale, $domain);
        }
    }

    public function findCustomDomain(int $userId): string
    {
        $dynamicDomain = self::DYNAMIC_DOMAIN.'-u'.$userId;
        $filename = $this->buildFileName(self::TRANSLATE_USER_TEMPLATE, [
            '%USER_ID%' => $userId,
            '%DOMAIN%' => $dynamicDomain,
            '%LOCALE%' => $this->locale,
        ]);

        if (file_exists($filename)) {
            return $dynamicDomain;
        }

        return self::DYNAMIC_DOMAIN;
    }

    public function getCustomAssetsContent(int $userId, string $filename, string $extension): string
    {
        $filename = $this->buildFileName(self::ASSETS_USER_TEMPLATE, [
            '%USER_ID%' => $userId,
            '%FILENAME%' => $filename,
            '%EXTENSION%' => $extension,
        ]);

        if (file_exists($filename)) {
            return file_get_contents($filename);
        }

        return '';
    }

    public function findCustomClassname(User $user, string $classname): ?string
    {
        $path = explode('\\', $classname);
        $classname = array_pop($path);

        $classname = $this->buildClassName(self::SERVICE_USER_NAMESPACE, [
            '%USER_ID%' => $user->getId(),
            '%CLASS_NAME%' => $classname,
        ]);
        if (class_exists($classname)) {
            return $classname;
        }

        return null;
    }

    private function buildFileName(string $template, array $parameters): string
    {
        return $this->pathCustomDir.str_replace(array_keys($parameters), array_values($parameters), $template);
    }

    private function buildClassName(string $template, array $parameters): string
    {
        return str_replace(array_keys($parameters), array_values($parameters), $template);
    }
}
