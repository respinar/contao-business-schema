<?php

/*
 * This file is part of Contao Organization Bundle.
 *
 * (c) Hamid Peywasti
 *
 * @license MIT
 */

declare(strict_types=1);

namespace Respinar\OrganizationSchemaBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Respinar\OrganizationSchemaBundle\RespinarOrganizationSchemaBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(RespinarOrganizationSchemaBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
