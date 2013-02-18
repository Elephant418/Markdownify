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

###  AppKernel.php

Add to `app/AppKernel.php`:
```
new PK\MarkdownifyBundle\PKMarkdownifyBundle()
```

## Usage
The bundle registers a `pk.markdownify` service. Use it as you would use the Markdownify class:

```php
$markdownify = $container->get('pk.markdownify');
$markdown = @$markdownify->parseString($html);
```

### NOTE: Warnings/notices
The original Markdownify code can sometimes raise warnings and notices. Since Symfony doesn't like that, the most pragmatic way to fix this is by silencing the parseString call (ie: putting an `@` in front of it). It would be nice to fix the original code, but without proper unit tests I'm not touching it.

## Modifications
The following modifications have been applied to the original Markdownify code.

* PSR 0 to 2 coding standards fix
* Organised properties and methods (properties first, then methods)
