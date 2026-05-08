<?php

/*
 * This file is part of Contao Organization Bundle.
 *
 * (c) Hamid Peywasti
 *
 * @license MIT
 */

declare(strict_types=1);

use Contao\CoreBundle\DataContainer\PaletteManipulator;

PaletteManipulator::create()
    ->addLegend('organization_legend', 'meta_legend', PaletteManipulator::POSITION_AFTER)
    ->addField(
        [
            'business_type',
            'business_name',
            'business_legal_name',
            'business_alternate_name',
            'business_founding_date',
            'business_url',
            'business_description',
            'business_logo',
            'business_telephone',
            'business_email',
            'business_street_address',
            'business_postal_code',
            'business_address_locality',
            'business_address_region',
            'business_address_country',
            'business_same_as',
        ],
        'organization_legend',
        PaletteManipulator::POSITION_APPEND,
    )
    ->applyToPalette('root', 'tl_page')
    ->applyToPalette('rootfallback', 'tl_page')
;

$GLOBALS['TL_DCA']['tl_page']['fields']['business_type'] = [
    'inputType' => 'select',
    'options' => ['organization', 'local_business'],
    'reference' => &$GLOBALS['TL_LANG']['tl_page']['business_type_options'],
    'eval' => ['tl_class' => 'w50'],
    'default' => 'organization',
];

$GLOBALS['TL_DCA']['tl_page']['fields']['business_name'] = [
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50 clr'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['business_legal_name'] = [
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['business_founding_date'] = [
    'inputType' => 'text',
    'eval' => ['maxlength' => 10, 'tl_class' => 'w50', 'placeholder' => 'YYYY-MM-DD', 'datepicker' => true, 'rgxp' => 'date'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['business_alternate_name'] = [
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50', 'placeholder' => 'Name 1, Name 2'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['business_url'] = [
    'inputType' => 'text',
    'eval' => ['rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 2048, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['business_description'] = [
    'inputType' => 'textarea',
    'eval' => ['tl_class' => 'clr'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['business_logo'] = [
    'inputType' => 'fileTree',
    'eval' => ['filesOnly' => true, 'fieldType' => 'radio', 'tl_class' => 'clr'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['business_telephone'] = [
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['business_email'] = [
    'inputType' => 'text',
    'eval' => ['rgxp' => 'email', 'maxlength' => 255, 'decodeEntities' => true, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['business_street_address'] = [
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['business_postal_code'] = [
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['business_address_locality'] = [
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['business_address_region'] = [
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['business_address_country'] = [
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['business_same_as'] = [
    'inputType' => 'listWizard',
    'eval' => [],
];
