[![Build Status](https://api.travis-ci.org/AdamB7586/pagination.png)](https://api.travis-ci.org/AdamB7586/pagination)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/AdamB7586/pagination/badges/quality-score.png?s=3758e21d279becdf847a557a56a3ed16dfec9d5d)](https://scrutinizer-ci.com/g/AdamB7586/pagination/)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg?style=flat-circle)](https://php.net/)

# Pagination


## Installation

Installation is available via [Composer/Packagist](https://packagist.org/packages/adamb/pagination), you can add the following line to your `composer.json` file:

```json
"adamb/pagination": "^1.0"
```

or

```sh
composer require adamb/pagination
```

## License

This software is distributed under the [MIT](https://github.com/AdamB7586/pagination/blob/master/LICENSE) license. Please read LICENSE for information on the
software availability and distribution.

## Features

- Creates a pagination HTML element
- Compatible with Bootstrap 3/4
- Change the class names assigned to the elements
- Easily change maximum number of links show
- If only 1 page exists no pager will be displayed

## Usage

### 1. Creating the pagination HTML

#### PHP Code
```php
<?php

require "src\Pagination.php";

use Pager\Pagination;

$numberOfRecords = 342; // This can also be generated from a database query
$pageURL = '/results.php';
$currentPage = $_GET['page'];
$resultsPerPage = 50; // This is the default value so can be removed

$pagination = new Pagination();
echo($pagination->paging($numberOfRecords, $pageURL, $currentPage, $resultsPerPage));

```

#### HTML Output
```html
<ul class="pagination">
    <li class="active"><a href="/results.php?page=1" title="Page 1">1</a></li>
    <li><a href="/results.php?page=2" title="Page 2">2</a></li>
    <li><a href="/results.php?page=3" title="Page 3">3</a></li>
    <li><a href="/results.php?page=4" title="Page 4">4</a></li>
    <li><a href="/results.php?page=5" title="Page 5">5</a></li>
    <li><a href="/results.php?page=6" title="Page 6">6</a></li>
    <li><a href="/results.php?page=7" title="Page 7">7</a></li>
    <li><a href="/results.php?page=2" title="Page &gt;">&gt;</a></li>
    <li><a href="/results.php?page=7" title="Page &raquo;">&raquo;</a></li>
</ul>
```

### 2. Changing the class names added to the HTML elements

#### PHP Code
```php
<?php

require "src\Pagination.php";

use Pager\Pagination;

$numberOfRecords = 342; // This can also be generated from a database query
$pageURL = '/results.php';
$currentPage = 3; //$_GET['page'];

$pagination = new Pagination();

$pagination->setPaginationClass('my_custom_pager')
           ->setActiveClass('this_is_active');

echo($pagination->paging($numberOfRecords, $pageURL, $currentPage));
```

#### HTML Output
```html
<ul class="my_custom_pager">
    <li><a href="/results.php?" title="Page &laquo;">&laquo;</a></li>
    <li><a href="/results.php?page=2" title="Page &lt;">&lt;</a></li>
    <li><a href="/results.php?page=1" title="Page 1">1</a></li>
    <li><a href="/results.php?page=2" title="Page 2">2</a></li>
    <li class="this_is_active"><a href="/results.php?page=3" title="Page 3">3</a></li>
    <li><a href="/results.php?page=4" title="Page 4">4</a></li>
    <li><a href="/results.php?page=5" title="Page 5">5</a></li>
    <li><a href="/results.php?page=6" title="Page 6">6</a></li>
    <li><a href="/results.php?page=7" title="Page 7">7</a></li>
    <li><a href="/results.php?page=2" title="Page &gt;">&gt;</a></li>
    <li><a href="/results.php?page=7" title="Page &raquo;">&raquo;</a></li>
</ul>
```

### 

### 3. Additional features

#### PHP Code
```php

```

#### HTML Output
```html

```

### 