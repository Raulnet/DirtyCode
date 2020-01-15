<?php

namespace App\Service\CustomService;

use App\Entity\Agency;
use App\Repository\MemberRepository;
use App\Service\AgencyService;
use App\Service\AgencyServiceInterface;

class AgencyServiceFactory
{
    private $overrideProvider;
    private $memberRepository;
    private $agencyService;

    public function __construct(
        OverrideProvider $overrideProvider,
        MemberRepository $memberRepository,
        AgencyService $agencyService
    ) {
        $this->overrideProvider = $overrideProvider;
        $this->memberRepository = $memberRepository;
        $this->agencyService = $agencyService;
    }

    public function getService(Agency $agency): AgencyServiceInterface
    {
        if ($customClassname = $this->overrideProvider->findCustomClassname($agency->getUser(), AgencyService::class)) {
            return new $customClassname($this->memberRepository);
        }

        return $this->agencyService;
    }
}
