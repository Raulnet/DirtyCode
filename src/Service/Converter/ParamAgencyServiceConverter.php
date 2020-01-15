<?php

namespace App\Service\Converter;

use App\Entity\Agency;
use App\Service\AgencyServiceInterface;
use App\Service\CustomService\AgencyServiceTaggedFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ParamAgencyServiceConverter implements ParamConverterInterface
{
    private $factory;

    public function __construct(AgencyServiceTaggedFactory $factory)
    {
        $this->factory = $factory;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $agency = $request->attributes->get($configuration->getOptions()['param']);
        if ($agency instanceof Agency) {
            $request->attributes->set(
                $configuration->getName(),
                $this->factory->getService($agency)
            );

            return true;
        }
        throw new NotFoundHttpException('Agency not found');
    }

    public function supports(ParamConverter $configuration): bool
    {
        return AgencyServiceInterface::class === $configuration->getClass();
    }
}
