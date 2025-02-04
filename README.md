# Confluence API Wrapper

A PHP wrapper for interacting with the Confluence REST API.

## Installation
```bash
composer require your-vendor/confluence-api-wrapper

use YourVendor\ConfluenceApiWrapper\ConfluenceApiClient;
```
## Usage
``` php
$client = new ConfluenceApiClient('https://your-domain.atlassian.net/wiki', 'your-email@example.com', 'your-api-token');
$content = $client->getSpaceContent('YOUR_SPACE_KEY');
print_r($content);
```