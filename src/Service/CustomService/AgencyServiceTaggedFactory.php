<?php

namespace App\Service\CustomService;

use App\Entity\Agency;
use App\Service\AgencyService;
use App\Service\AgencyServiceInterface;

class AgencyServiceTaggedFactory
{
    private $serviceCollection;
    private $overrideProvider;

    // App\Service\CustomService\AgencyServiceTaggedFactory

    public function __construct(iterable $serviceCollection, OverrideProvider $overrideProvider)
    {
        $this->serviceCollection = iterator_to_array($serviceCollection);
        $this->overrideProvider = $overrideProvider;
    }

    public function getService(Agency $agency): AgencyServiceInterface
    {
        if ($customClassname = $this->overrideProvider->findCustomClassname($agency->getUser(), AgencyService::class)) {
            return $this->serviceCollection[$customClassname];
        }

        return  $this->serviceCollection[AgencyService::class];
    }
}
