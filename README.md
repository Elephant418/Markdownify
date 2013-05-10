Markdownify
===================

The HTML to Markdown converter for PHP.

See [http://milianw.de/projects/markdownify/](The official website)


Code example
--------

```php
$md = new Markdownify\Converter;
echo $md->parseString($htmlInput);
```

[&uarr; top](#readme)



How to Install
--------

If you don't have composer, you have to [install it](http://getcomposer.org/doc/01-basic-usage.md#installation).

Add or complete the composer.json file at the root of your repository, like this :

```json
{
    "require": {
        "tzi/markdownify": "2.1.*"
    }
}
```

Markdownify can now be [downloaded via composer](http://getcomposer.org/doc/01-basic-usage.md#installing-dependencies).

[&uarr; top](#readme)



How to Contribute
--------

1. Fork the Markdownify repository
2. Create a new branch for each feature or improvement
3. Send a pull request from each feature branch to the **develop** branch

If you don't know much about pull request, you can read [the Github article](https://help.github.com/articles/using-pull-requests).

[&uarr; top](#readme)



Author & Community
--------

Markdownify is under [LGPL License](http://opensource.org/licenses/LGPL-2.1).

It was created by [Milian Wolff](http://milianw.de).

It was converted to a Symfony Bundle by [Peter Kruithof](https://github.com/pkruithof).

It was converted made accessible by composer without Symfony by [Thomas ZILLIOX](http://zilliox.me).

[&uarr; top](#readme)