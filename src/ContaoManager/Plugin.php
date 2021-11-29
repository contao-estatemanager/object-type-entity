<?php

/*
 * This file is part of Oveleon Object Type Entity.
 *
 * (c) https://www.oveleon.de/
 */

declare(strict_types=1);

namespace ContaoEstateManager\ObjectTypeEntity\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use ContaoEstateManager\ObjectTypeEntity\ObjectTypeEntity;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(ObjectTypeEntity::class)
                        ->setLoadAfter([ContaoCoreBundle::class])
        ];
    }
}
