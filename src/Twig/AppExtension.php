<?php

namespace App\Twig;

use App\Service\CustomService\OverrideProvider;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private $customOverrideProvider;

    public function __construct(OverrideProvider $customOverrideProvider)
    {
        $this->customOverrideProvider = $customOverrideProvider;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('dynamic_domain', [$this, 'dynamicDomain']),
        ];
    }

    public function dynamicDomain(int $userId): string
    {
        return $this->customOverrideProvider->findCustomDomain($userId);
    }

    public function findNavBarUser(): array
    {
    }
}
