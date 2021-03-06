<?php

namespace Prezent\Grid\Tests\PHPUnit;

use Prezent\Grid\Twig\GridExtension;
use Prezent\Grid\Twig\GridRenderer;

trait TwigProvider
{
    private $twig;

    private $constraintClass;

    private function setUpTwig()
    {
        $renderer = new GridRenderer(['grid.html.twig']);
        $this->twig = new GridExtension($renderer);
        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../../src/Resources/views/Grid');

        $environment = new \Twig_Environment($loader, array('strict_variables' => true));
        $environment->addExtension($this->twig);
        $environment->addExtension(new \Twig_Extensions_Extension_Text());

        $this->twig->initRuntime($environment);
    }

    public static function assertMatchesXpath($expression, $html, $count = 1, $message = '')
    {
        self::assertThat($html, self::matchesXpath($expression, $count), $message);
    }

    public static function matchesXpath($expression, $count = 1)
    {
        if (class_exists('PHPUnit\\Runner\\Version')) {
            $versionClass = 'PHPUnit\\Runner\\Version';
        } else {
            $versionClass = 'PHPUnit_Runner_Version';
        }

        $version = strstr($versionClass::id(), '.', true);

        if ($version == '5') {
            $constraintClass = 'Prezent\\Grid\\Tests\\PHPUnit\\MatchesXpath5';
        } elseif ($version == '6') {
            $constraintClass = 'Prezent\\Grid\\Tests\\PHPUnit\\MatchesXpath6';
        } else {
            $constraintClass = 'Prezent\\Grid\\Tests\\PHPUnit\\MatchesXpath';
        }

        return new $constraintClass($expression, $count);
    }
}
