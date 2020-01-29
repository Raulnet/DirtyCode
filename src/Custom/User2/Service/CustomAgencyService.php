<?php

namespace App\Custom\User2\Service;

use App\Entity\Agency;
use App\Entity\Member;
use App\Repository\MemberRepository;
use App\Service\AgencyServiceInterface;
use Symfony\Component\HttpClient\HttpClient;

class CustomAgencyService implements AgencyServiceInterface
{
    private const EXTERNAL_API_PATH = 'https://jsonplaceholder.typicode.com/users';
    private $memberRepository;

    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public static function getDefaultServiceName(): string
    {
        return \get_called_class();
    }

    public function getMembersAgency(Agency $agency): array
    {
        $client = HttpClient::create();
        $response = $client->request('GET', self::EXTERNAL_API_PATH);
        if (200 === $response->getStatusCode()) {
            return $this->buildMembers($response->getContent(), $agency);
        }

        return [];
    }

    private function buildMembers(string $json, Agency $agency): array
    {
        $members = [];
        foreach (json_decode($json, true) as $dataMember) {
            $members[] = Member::createFromData($dataMember, $agency);
        }

        return $members;
    }
}
