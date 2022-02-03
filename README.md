# bcmath_compat

[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]

PHP 5.x-8.x polyfill for bcmath extension

## Installation

With [Composer](https://getcomposer.org/):

```bash
$ composer require phpseclib/bcmath_compat
```

## Limitations

- `extension_loaded('bcmath')`

  bcmath_compat cannot make this return true. The recommended remediation is to not do this.

- `ini_set('bcmath.scale', ...)`

  You cannot set configuration options for extensions that are not installed. If you do `ini_set('bcmath.scale', 5)` on a system without bcmath installed then `ini_get('bcmath.scale')` will return `false`. It's similar to what happens when you do `ini_set('zzz', 5)` and then `ini_get('zzz')`. You'll get `false` back.

  The recommended remediation to doing `ini_set('bcmath.scale', ...)` is to do `bcscale(...)`. The recommended remediation for doing `ini_get` is (if you're using PHP >= 7.3.0) to do `bcscale()` or (if you're using PHP < 7.3.0) to do `max(0, strlen(bcadd('0', '0')) - 2)`.

  Note that `ini_get` always returns a string whereas the recommended remediations return integers.

[ico-version]: https://img.shields.io/packagist/v/phpseclib/bcmath_compat.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phpseclib/bcmath_compat/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/phpseclib/bcmath_compat.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/phpseclib/bcmath_compat.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phpseclib/bcmath_compat.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/phpseclib/bcmath_compat
[link-travis]: https://travis-ci.org/phpseclib/bcmath_compat
[link-scrutinizer]: https://scrutinizer-ci.com/g/phpseclib/bcmath_compat/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/phpseclib/bcmath_compat
[link-downloads]: https://packagist.org/packages/phpseclib/bcmath_compat
