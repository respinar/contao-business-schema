<?php

/*
 * This file is part of Contao Business Bundle.
 *
 * (c) Hamid Peywasti
 *
 * @license MIT
 */

declare(strict_types=1);

namespace Respinar\BusinessSchemaBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Respinar\BusinessSchemaBundle\RespinarBusinessSchemaBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(RespinarBusinessSchemaBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
