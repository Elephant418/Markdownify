MarkdownifyBundle
===================

Provides Symfony2 integration for the Markdownify/Markdownify_Extra scripts.

See http://milianw.de/projects/markdownify/

## Requirements
The bundle is built for Symfony 2.1 and while version 2.0 should work with it, it is not officialy supported.

## Installation
Install the bundle using composer.

### Automatically
```
php composer.phar require "pk/markdownify-bundle:2.1.*"
```

### Manually
Add to `composer.json`:
```
"pk/markdownify-bundle": "2.1.*"
```

and update:
```
php composer.phar update "pk/markdownify-bundle"
```

## Usage
The bundle registers a `pk.markdownify` service. Use it as you would use the Markdownify class:

```php
$markdownify = $container->get('pk.markdownify');
$markdown = $markdownify->parseString($html);
```

## Modifications
The following modifications have been applied to the original Markdownify code.

* PSR 0 to 2 coding standards fix
* Organised properties and methods (properties first, then methods)
