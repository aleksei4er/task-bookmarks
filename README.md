# Task Bookmarks

[![GitHub Workflow Status](https://github.com/aleksei4er/task-bookmarks/workflows/Run%20tests/badge.svg)](https://github.com/aleksei4er/task-bookmarks/actions)
[![styleci](https://styleci.io/repos/CHANGEME/shield)](https://styleci.io/repos/CHANGEME)

[![Packagist](https://img.shields.io/packagist/v/aleksei4er/task-bookmarks.svg)](https://packagist.org/packages/aleksei4er/task-bookmarks)
[![Packagist](https://poser.pugx.org/aleksei4er/task-bookmarks/d/total.svg)](https://packagist.org/packages/aleksei4er/task-bookmarks)
[![Packagist](https://img.shields.io/packagist/l/aleksei4er/task-bookmarks.svg)](https://packagist.org/packages/aleksei4er/task-bookmarks)

Package description: This is a Laravel package for fun.

## Installation

Install via composer
```bash
composer require aleksei4er/task-bookmarks
```

### Publish package assets for web interface
```bash
php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"
```

### Install web interface
```bash
php artisan admin:install
```

## Usage

After that, the interface will be available at
yourdomain.com/admin/bookmarks

If you want to add test data, run 

```bash
php artisan db:seed --class=BookmarkSeeder
```

## Security

If you discover any security related issues, please email 
instead of using the issue tracker.

## Credits

- [](https://github.com/aleksei4er/task-bookmarks)
- [All contributors](https://github.com/aleksei4er/task-bookmarks/graphs/contributors)

This package is bootstrapped with the help of
[melihovv/laravel-package-generator](https://github.com/melihovv/laravel-package-generator).
