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
    public function __construct(private readonly ResponseContextAccessor $responseContextAccessor)
    {
    }

    public function __invoke(PageModel $pageModel): void
    {
        $rootPage = PageModel::findById($pageModel->rootId);

        if (null === $rootPage) {
            return;
        }

        $responseContext = $this->responseContextAccessor->getResponseContext();

        if (null === $responseContext || !$responseContext->has(JsonLdManager::class)) {
            return;
        }

        $jsonLdManager = $responseContext->get(JsonLdManager::class);

        $graph = $jsonLdManager->getGraphForSchema(
            JsonLdManager::SCHEMA_ORG,
        );

        if (empty($rootPage->pageTitle) || empty($rootPage->dns)) {
            return;
        }

        $scheme = $rootPage->useSSL ? 'https://' : 'http://';
        $baseUrl = $scheme.rtrim($rootPage->dns, '/');

        $websiteId = $baseUrl.'/#website';

        $website = new WebSite();

        $website
            ->identifier($websiteId)
            ->name($rootPage->pageTitle)
            ->url($baseUrl.'/')
        ;

        $graph->add($website);
    }
}
