<?php

namespace App\Service;

use App\Entity\Agency;
use App\Repository\MemberRepository;

class AgencyService implements AgencyServiceInterface
{
    private $memberRepository;

    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function getMembersAgency(Agency $agency): array
    {
        return $this->memberRepository->findBy(['agency' => $agency]);
    }

    public static function getDefaultServiceName(): string
    {
        return \get_called_class();
    }
}
