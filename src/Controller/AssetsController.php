<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\CustomService\OverrideProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AssetsController extends AbstractController
{
    private const CONTENT_TYPE = [
        'css' => 'text/css',
        'js' => 'application/javascript',
    ];

    /**
     * @Route("/custom_assets/{id}/{filename}.{extension}",
     *     name="custom_assets",
     *     requirements={"extension"="(css|js)"}
     * )
     */
    public function customAssets(OverrideProvider $provider, User $user, string $filename, string $extension): Response
    {
        return (new Response(
            $provider->getCustomAssetsContent($user->getId(), $filename, $extension),
            200,
            ['content-type' => self::CONTENT_TYPE[$extension]])
        )->setMaxAge(120);
    }
}
