# Article Bookmark

[![Latest Version on Packagist](https://img.shields.io/packagist/v/onkaargujarr/library.svg?style=flat-square)](https://packagist.org/packages/onkaargujarr/library)
[![Total Downloads](https://img.shields.io/packagist/dt/onkaargujarr/library.svg?style=flat-square)](https://packagist.org/packages/onkaargujarr/library)
![GitHub Actions](https://github.com/onkaargujarr/library/actions/workflows/main.yml/badge.svg)

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.

## Installation
Include this in your composer.json file.
```
"repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:cactuscommunications/clevertap.git",
            "no-api": true
        }
    ]
```  
Installation Steps:-
1. composer require onkaargujarr/library

2. php artisan vendor:publish --provider="OnkaarGujarr\Library\LibraryServiceProvider"

3. php artisan migrate

## Usage

1.  To fetch all thee bookmark:
LibraryFacade::getAllLibrary()

2. Save Bookmark
LibraryFacade::saveToLibrary($articleId)

3. Delete Bookmark
LibraryFacade::removeFromLibrary($articleId)

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email onkar.gujar@cactusglobal.com instead of using the issue tracker.

## Credits

-   [Onkar](https://github.com/onkaargujarr)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
