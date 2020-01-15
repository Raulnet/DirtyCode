<?php

namespace App\Tests\Custom;

use App\Service\AgencyServiceInterface;
use PHPUnit\Framework\TestCase;
use SplFileInfo;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class AutomaticCustomTest extends TestCase
{
    private const DEFAULT_FILE_DYNAMIC_DOMAIN = __DIR__.'/../../translations/dynamic.en_GB.yaml';
    private const CUSTOM_FILE_SUPPORTED = [
        'custom_jumbotron.html.twig',
        'custom_agency_style.css',
        'custom_style.css',
        'CustomAgencyService.php',
    ];

    /**
     * @dataProvider customFileProvider
     */
    public function testOverrideSupported(SplFileInfo $fileInfo): void
    {
        $this->assertTrue($this->fileIsSupported($fileInfo), $fileInfo->getFilename().' is not supported.');
    }

    public function customFileProvider(): iterable
    {
        $finder = new Finder();
        $finder->files()->in(__DIR__.'/../../src/Custom');

        foreach ($finder as $file) {
            yield [$file->getFileInfo()];
        }
    }

    /**
     * @dataProvider customAgencyServiceProvider
     */
    public function testCustomAgencyService(SplFileInfo $fileInfo): void
    {
        $classname = str_replace(['/srv/src/', '/', '.php'], ['App\\', '\\', ''], $fileInfo->getRealPath());

        $this->assertInstanceOf(AgencyServiceInterface::class, $this->prophesize($classname)->reveal());
    }

    public function customAgencyServiceProvider(): iterable
    {
        $finder = new Finder();
        $finder->files()->in(__DIR__.'/../../src/Custom')->name('CustomAgencyService.php');

        foreach ($finder as $file) {
            yield [$file->getFileInfo()];
        }
    }

    private function dynamicDomainTest(SplFileInfo $fileInfo): void
    {
        if ($this->isDynamicTranslateFile($fileInfo)) {
            $defaultDynamic = Yaml::parse(file_get_contents(self::DEFAULT_FILE_DYNAMIC_DOMAIN));
            $dynamic = Yaml::parse(file_get_contents($fileInfo->getPathname()));
            foreach ($defaultDynamic as $requiredKey => $value) {
                $this->assertTrue(\array_key_exists($requiredKey, $dynamic), $fileInfo->getFilename()." doesn't have required key: $requiredKey");
            }
        }
    }

    private function fileIsSupported(SplFileInfo $fileInfo): bool
    {
        if (\in_array($fileInfo->getFilename(), self::CUSTOM_FILE_SUPPORTED, true)) {
            return true;
        }
        if ($this->isDynamicTranslateFile($fileInfo)) {
            $this->dynamicDomainTest($fileInfo);

            return true;
        }

        return false;
    }

    private function isDynamicTranslateFile(SplFileInfo $fileInfo): bool
    {
        if (!\in_array($fileInfo->getExtension(), ['yaml', 'yml'], true)) {
            return false;
        }

        $elem = explode('.', $fileInfo->getFilename());
        if (3 !== \count($elem)) {
            return false;
        }

        if ('dynamic' !== explode('-', $elem[0])[0]) {
            return false;
        }

        return true;
    }
}
