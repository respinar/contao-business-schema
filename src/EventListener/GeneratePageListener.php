<?php

/*
 * This file is part of Contao Business Bundle.
 *
 * (c) Hamid Peywasti
 *
 * @license MIT
 */

declare(strict_types=1);

namespace Respinar\BusinessSchemaBundle\EventListener;

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

        if (null === $rootPage || empty($rootPage->business_name)) {
            return;
        }

        $responseContext = $this->responseContextAccessor->getResponseContext();

        if (null === $responseContext || !$responseContext->has(JsonLdManager::class)) {
            return;
        }

        $jsonLdManager = $responseContext->get(JsonLdManager::class);
        $graph = $jsonLdManager->getGraphForSchema(JsonLdManager::SCHEMA_ORG);
        $id = Environment::get('url').'/#organization';

        $org = match ($rootPage->business_type) {
            'local_business' => $graph->localBusiness($id),
            default => $graph->organization($id),
        };
        $org->identifier($id);
        $org->name($rootPage->business_name);

        if (!empty($rootPage->business_legal_name)) {
            $org->legalName($rootPage->business_legal_name);
        }

        if (!empty($rootPage->business_alternate_name)) {
            $alternateNames = array_values(array_filter(array_map(
                static fn (string $name): string => trim($name),
                explode(',', $rootPage->business_alternate_name),
            )));

            if ([] !== $alternateNames) {
                $org->alternateName($alternateNames);
            }
        }

        if (!empty($rootPage->business_description)) {
            $org->description($rootPage->business_description);
        }

        if (!empty($rootPage->business_url)) {
            $org->url($rootPage->business_url);
        }

        if (!empty($rootPage->business_logo)) {
            $logoUrl = $this->resolveFileUrl($rootPage->business_logo);

            if (null !== $logoUrl) {
                $org->logo($logoUrl);
            }
        }

        if (!empty($rootPage->business_telephone) || !empty($rootPage->business_email)) {
            $contactPoint = new ContactPoint();

            if (!empty($rootPage->business_telephone)) {
                $contactPoint->telephone($rootPage->business_telephone);
            }

            if (!empty($rootPage->business_email)) {
                $contactPoint->email($rootPage->business_email);
            }

            $org->contactPoint($contactPoint);
        }

        if (
            !empty($rootPage->business_street_address)
            || !empty($rootPage->business_postal_code)
            || !empty($rootPage->business_address_locality)
            || !empty($rootPage->business_address_region)
            || !empty($rootPage->business_address_country)
        ) {
            $address = new PostalAddress();

            if (!empty($rootPage->business_street_address)) {
                $address->streetAddress($rootPage->business_street_address);
            }

            if (!empty($rootPage->business_postal_code)) {
                $address->postalCode($rootPage->business_postal_code);
            }

            if (!empty($rootPage->business_address_locality)) {
                $address->addressLocality($rootPage->business_address_locality);
            }

            if (!empty($rootPage->business_address_region)) {
                $address->addressRegion($rootPage->business_address_region);
            }

            if (!empty($rootPage->business_address_country)) {
                $address->addressCountry($rootPage->business_address_country);
            }

            $org->address($address);
        }

        if (!empty($rootPage->business_same_as)) {
            $sameAs = array_values(array_filter(StringUtil::deserialize($rootPage->business_same_as, true)));

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
