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
            'orgschema_name',
            'orgschema_legal_name',
            'orgschema_alternate_name',
            'orgschema_url',
            'orgschema_description',
            'orgschema_logo',
            'orgschema_telephone',
            'orgschema_email',
            'orgschema_street_address',
            'orgschema_postal_code',
            'orgschema_address_locality',
            'orgschema_address_region',
            'orgschema_address_country',
            'orgschema_same_as',
        ],
        'organization_legend',
        PaletteManipulator::POSITION_APPEND,
    )
    ->applyToPalette('root', 'tl_page')
    ->applyToPalette('rootfallback', 'tl_page')
;

$GLOBALS['TL_DCA']['tl_page']['fields']['orgschema_name'] = [
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['orgschema_legal_name'] = [
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['orgschema_alternate_name'] = [
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50', 'placeholder' => 'Name 1, Name 2'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['orgschema_url'] = [
    'inputType' => 'text',
    'eval' => ['rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 2048, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['orgschema_description'] = [
    'inputType' => 'textarea',
    'eval' => ['tl_class' => 'clr'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['orgschema_logo'] = [
    'inputType' => 'fileTree',
    'eval' => ['filesOnly' => true, 'fieldType' => 'radio', 'tl_class' => 'clr'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['orgschema_telephone'] = [
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['orgschema_email'] = [
    'inputType' => 'text',
    'eval' => ['rgxp' => 'email', 'maxlength' => 255, 'decodeEntities' => true, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['orgschema_street_address'] = [
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['orgschema_postal_code'] = [
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['orgschema_address_locality'] = [
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['orgschema_address_region'] = [
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['orgschema_address_country'] = [
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
];

$GLOBALS['TL_DCA']['tl_page']['fields']['orgschema_same_as'] = [
    'inputType' => 'listWizard',
    'eval' => [],
];
