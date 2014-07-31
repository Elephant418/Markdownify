Markdownify 3 [![Build Status](https://travis-ci.org/Pixel418/Markdownify.png?branch=v3.x)](https://travis-ci.org/Pixel418/Markdownify)
===================

The next version of the HTML to Markdown converter for PHP.

WARNING: This version is not ready yet.

1. [Quick start](#quick-start)
2. [How to Install](#how-to-install)
3. [How to Contribute](#how-to-contribute)
4. [Author & Community](#author--community)

Quick start
--------

```php
$converter = new \Markdownify\Converter;
$converter->load('<h1>Heading</h1>');
echo $converter->save(); // # Heading
```

[&uarr; top](#readme)



How to Install
--------

If you don't have composer, you have to [install it](http://getcomposer.org/doc/01-basic-usage.md#installation).<br>
Add or complete the composer.json file at the root of your repository, like this :

```json
{
    "require": {
        "pixel418/markdownify": "dev-v3.x"
    }
}
```

Markdownify can now be [downloaded via composer](http://getcomposer.org/doc/01-basic-usage.md#installing-dependencies).

[&uarr; top](#readme)



How to Contribute
--------

1. Fork the Markdownify repository
2. Create a new branch for each feature or improvement
3. Send a pull request from each feature branch to the **v3.x** branch

If you don't know much about pull request, you can read [the Github article](https://help.github.com/articles/using-pull-requests).

[&uarr; top](#readme)



Author & Community
--------

Markdownify is under [MIT License](http://opensource.org/licenses/MIT).<br>
It was created by [Milian Wolff](http://milianw.de).<br>
It was maintained & finally rewrote by [Thomas ZILLIOX](http://tzi.fr).

[&uarr; top](#readme)
