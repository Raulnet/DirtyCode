<?php

namespace App\Service;

use App\Entity\Agency;
use App\Repository\MemberRepository;

interface AgencyServiceInterface
{
    public function __construct(MemberRepository $memberRepository);

    public function getMembersAgency(Agency $agency): array;

    public static function getDefaultServiceName(): string;
}
