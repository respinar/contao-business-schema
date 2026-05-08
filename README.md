# Contao Business Schema

A lightweight [Contao](https://contao.org) bundle for managing [Organization](https://schema.org/Organization) Schema.org data from the root page and adding it to Contao's existing Schema.org / JSON-LD graph.

## Features

- Configure Organization data directly on the Contao **root page**
- Output is added to Contao's existing Schema.org / JSON-LD graph (no duplicate markup)
- All fields are **virtual** — no database columns are added to `tl_page`
- Supports Identity, Contact, Address, and Social Profiles data
- English (`en`), German (`de`), and Persian (`fa`) translations

## Requirements

- Contao `^5.7`
- PHP `^8.3`

## Installation

Install the bundle via Composer:

```bash
composer require respinar/contao-business-schema
```

Then install and activate the bundle through the [Contao Manager](https://contao.org/en/manager.html) or `contao/installer`.

## Configuration

Once installed, open the **root page** in the Contao back end. An **Organization** section appears below the *Meta information* section where you can enter:

Start by choosing the **Schema type** — either `Organization` or `Local business` — which determines the `@type` of the output node.

### Identity

- Schema type *(Organization or Local business)*
- Name
- Legal name
- Founding date *(ISO 8601, e.g. `1995-03-14`)*
- Alternate name *(add multiple names as separate entries)*
- Description
- Website URL
- Logo *(output as an image object with URL, width and height)*

### Contact

- Telephone
- Email

### Address

- Street address
- Postal code
- City / locality
- State / region
- Country

### Social Profiles

- Social media profile URLs

Only fields with a value are included in the output. The Organization node uses a stable `@id` based on the website URL, e.g. `https://example.com/#organization`.

## Output

The bundle adds a `schema.org` Organization node to Contao's JSON-LD graph, for example:

```json
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "@id": "https://example.com/#organization",
  "name": "Foolad Gharb",
  "alternateName": ["فولادغرب", "Foolad Gharb"],
  "url": "https://example.com",
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+1-555-0100",
    "email": "info@example.com"
  },
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "123 Main St",
    "postalCode": "12345",
    "addressCountry": "US"
  }
}
```

## License

This bundle is licensed under the [MIT License](LICENSE).
