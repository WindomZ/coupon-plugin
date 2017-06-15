# coupon-plugin

> Developing...

[![Latest Stable Version](https://img.shields.io/packagist/v/windomz/coupon-plugin.svg?style=flat-square)](https://packagist.org/packages/windomz/coupon-plugin)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.0-8892BF.svg?style=flat-square)](https://php.net/)
[![Minimum MYSQL Version](https://img.shields.io/badge/mysql-%3E%3D%205.6-4479a1.svg?style=flat-square)](https://www.mysql.com/)
[![Build Status](https://img.shields.io/travis/WindomZ/coupon-plugin/master.svg?style=flat-square)](https://travis-ci.org/WindomZ/coupon-plugin)

## Feature

- [x] Activity
- [x] CouponTemplate
- [x] Pack = Activity + CouponTemplate
- [x] Coupon = one of Pack

## Installation

Open the terminal in the project directory:
```bash
$ composer require windomz/coupon-plugin
```

Create a configuration file, like `config.yml`:
```yaml
database:
    host: 127.0.0.1
    port: 3306
    type: mysql
    name: testdb
    username: root
    password: root
```

If only for quick testing, 
you can run `./sql/testdb.sql` in `MySQL` to quickly create a test database.

Of course, you can also customize the `database name` based on `./sql/testdb.sql`, 
but note that the `table name` can not be _MODIFIED_!

In the project initialization, 
load the specified configuration file through the following implementation:
```php
Coupon::setConfigPath('./config.yml');
```

## Usage

Refer to the [Document](https://windomz.github.io/coupon-plugin)(_Currently only Chinese_) for details.

## License

The [MIT License](https://github.com/WindomZ/coupon-plugin/blob/master/LICENSE)
