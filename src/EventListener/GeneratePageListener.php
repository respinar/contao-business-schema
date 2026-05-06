<?php

/*
 * This file is part of Contao Organization Bundle.
 *
 * (c) Hamid Peywasti
 *
 * @license MIT
 */

declare(strict_types=1);

namespace Respinar\OrganizationSchemaBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\CoreBundle\Routing\ResponseContext\JsonLd\JsonLdManager;
use Contao\CoreBundle\Routing\ResponseContext\ResponseContextAccessor;
use Contao\Environment;
use Contao\FilesModel;
use Contao\PageModel;
use Contao\StringUtil;
use Spatie\SchemaOrg\ContactPoint;
use Spatie\SchemaOrg\PostalAddress;

#[AsHook('generatePage')]
class GeneratePageListener
{
    public function __construct(private readonly ResponseContextAccessor $responseContextAccessor)
    {
    }

    public function __invoke(PageModel $pageModel): void
    {
        $rootPage = PageModel::findById($pageModel->rootId);

        if (null === $rootPage || empty($rootPage->orgschema_name)) {
            return;
        }

        $responseContext = $this->responseContextAccessor->getResponseContext();

        if (null === $responseContext || !$responseContext->has(JsonLdManager::class)) {
            return;
        }

        $jsonLdManager = $responseContext->get(JsonLdManager::class);
        $graph = $jsonLdManager->getGraphForSchema(JsonLdManager::SCHEMA_ORG);
        $id = Environment::get('url').'/#organization';

        $org = $graph->organization($id);
        $org->name($rootPage->orgschema_name);

        if (!empty($rootPage->orgschema_legal_name)) {
            $org->legalName($rootPage->orgschema_legal_name);
        }

        if (!empty($rootPage->orgschema_alternate_name)) {
            $alternateNames = array_values(array_filter(array_map(
                static fn (string $name): string => trim($name),
                explode(',', $rootPage->orgschema_alternate_name),
            )));

            if ([] !== $alternateNames) {
                $org->alternateName($alternateNames);
            }
        }

        if (!empty($rootPage->orgschema_description)) {
            $org->description($rootPage->orgschema_description);
        }

        if (!empty($rootPage->orgschema_url)) {
            $org->url($rootPage->orgschema_url);
        }

        if (!empty($rootPage->orgschema_logo)) {
            $logoUrl = $this->resolveFileUrl($rootPage->orgschema_logo);

            if (null !== $logoUrl) {
                $org->logo($logoUrl);
            }
        }

        if (!empty($rootPage->orgschema_telephone) || !empty($rootPage->orgschema_email)) {
            $contactPoint = new ContactPoint();

            if (!empty($rootPage->orgschema_telephone)) {
                $contactPoint->telephone($rootPage->orgschema_telephone);
            }

            if (!empty($rootPage->orgschema_email)) {
                $contactPoint->email($rootPage->orgschema_email);
            }

            $org->contactPoint($contactPoint);
        }

        if (
            !empty($rootPage->orgschema_street_address)
            || !empty($rootPage->orgschema_postal_code)
            || !empty($rootPage->orgschema_address_locality)
            || !empty($rootPage->orgschema_address_region)
            || !empty($rootPage->orgschema_address_country)
        ) {
            $address = new PostalAddress();

            if (!empty($rootPage->orgschema_street_address)) {
                $address->streetAddress($rootPage->orgschema_street_address);
            }

            if (!empty($rootPage->orgschema_postal_code)) {
                $address->postalCode($rootPage->orgschema_postal_code);
            }

            if (!empty($rootPage->orgschema_address_locality)) {
                $address->addressLocality($rootPage->orgschema_address_locality);
            }

            if (!empty($rootPage->orgschema_address_region)) {
                $address->addressRegion($rootPage->orgschema_address_region);
            }

            if (!empty($rootPage->orgschema_address_country)) {
                $address->addressCountry($rootPage->orgschema_address_country);
            }

            $org->address($address);
        }

        if (!empty($rootPage->orgschema_same_as)) {
            $sameAs = array_values(array_filter(StringUtil::deserialize($rootPage->orgschema_same_as, true)));

            if ([] !== $sameAs) {
                $org->sameAs($sameAs);
            }
        }
    }

    private function resolveFileUrl(string $uuid): string|null
    {
        $model = FilesModel::findByUuid($uuid);

        if (null === $model || '' === $model->path) {
            return null;
        }

        return Environment::get('url').'/'.$model->path;
    }
}
