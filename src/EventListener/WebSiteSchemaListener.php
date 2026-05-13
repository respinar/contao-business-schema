<?php

declare(strict_types=1);

/*
 * This file is part of Contao Vatan Bundle.
 *
 * (c) Hamid Peywasti
 *
 * @license MIT
 */

namespace Respinar\BusinessSchemaBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\CoreBundle\Routing\ResponseContext\JsonLd\JsonLdManager;
use Contao\CoreBundle\Routing\ResponseContext\ResponseContextAccessor;
use Contao\PageModel;
use Spatie\SchemaOrg\WebSite;

#[AsHook('generatePage')]
class WebSiteSchemaListener
{
    public function __construct(
        private readonly ResponseContextAccessor $responseContextAccessor,
    ) {
    }

    public function __invoke(PageModel $pageModel): void
    {
        $rootPage = PageModel::findById($pageModel->rootId);

        if (null === $rootPage) {
            return;
        }

        $responseContext = $this->responseContextAccessor->getResponseContext();

        if (
            null === $responseContext
            || !$responseContext->has(JsonLdManager::class)
        ) {
            return;
        }

        $jsonLdManager = $responseContext->get(JsonLdManager::class);

        $graph = $jsonLdManager->getGraphForSchema(
            JsonLdManager::SCHEMA_ORG,
        );

        /*
         * Website name
         */
        $websiteName = $rootPage->pageTitle ?: $rootPage->title;

        if (empty($websiteName)) {
            return;
        }

        /*
         * Website URL
         */
         if (!empty($rootPage->dns)) {
             $scheme = $rootPage->useSSL ? 'https://' : 'http://';
             $websiteUrl = $scheme.rtrim($rootPage->dns, '/').'/';
         } else {
             $websiteUrl = rtrim($rootPage->getAbsoluteUrl(), '/').'/';
         }

        /*
         * WebSite Schema
         */
        $websiteId = $websiteUrl.'#website';

        $website = new WebSite();

        $website
            ->identifier($websiteId)
            ->name($websiteName)
            ->url($websiteUrl)
        ;

        $graph->add($website);
    }
}
