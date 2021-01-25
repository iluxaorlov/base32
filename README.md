# Base32

Base32 encoding and decoding library for PHP

```php
<?php

use Iluxaorlov\Base32;

// $encoded contains 'MZXW6==='
$encoded = Base32::encode('foo');

// $encoded contains 'MZXW6'
$encoded = Base32::encode('foo', false);

// $decoded contains 'foo'
$decoded = Base32::decode($encoded);
```

## Installation
Use [Composer](https://getcomposer.org) to install:

```
composer require iluxaorlov/base32
```

