# AGENTS.md

## Project

`respinar/contao-business-schema`

A small Contao bundle for managing Organization Schema.org data from the Contao root page.

## Requirements

* Contao `5.7+`
* PHP `8.3+`

## Code Style

* Follow the Contao coding standards.
* Use **ECS (Easy Coding Standard)** with the standard Contao configuration.
* Keep the code simple and minimal.
* Do not add unnecessary abstractions or dependencies.

## Contao

* Use Contao's existing APIs and extension points.
* Do not modify the Contao core.
* Organization data is configured on the **root page**.
* The Organization Schema must be added to Contao's existing Schema.org / JSON-LD graph.

## Fields

All fields must be **virtual fields**.

Do not add database columns to `tl_page`.

The Organization configuration should provide these fields:

### Identity

* `business_type`
* `business_name`
* `business_legal_name`
* `business_founding_date`
* `business_alternate_name`
* `business_description`
* `business_url`
* `business_logo`

### Contact

* `business_telephone`
* `business_email`

### Address

* `business_street_address`
* `business_postal_code`
* `business_address_locality`
* `business_address_region`
* `business_address_country`

### Social Profiles

* `business_same_as`

## Schema

* Use `https://schema.org/Organization` or `https://schema.org/LocalBusiness` depending on `business_type`.
* Use a stable `@id` for the Organization.
* The `@id` should normally be based on the website URL, for example:
  `https://example.com/#organization`
* Only output properties that have a value.
* Do not output duplicate JSON-LD outside Contao's Schema.org graph.

## General

* Prefer the simplest working solution.
* Keep the public API small.
* Follow Contao conventions for naming, services, DCA, and configuration.
* Do not add fields or features that are not required for Organization Schema.

## Internationalization

- Use XLIFF files for all translatable labels, legends, field names, descriptions, and messages.
- Do not hard-code user-facing text in PHP, DCA, Twig, or JavaScript.
- Follow Contao's standard language file conventions.
- Provide English (`en`) as the default language.
- Keep translation keys consistent and descriptive.
