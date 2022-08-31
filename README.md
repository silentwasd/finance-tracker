# Finance Tracker

Simple way to track your money. Application allows to
track income and expense transactions and assign to
them any categories that you want.

You can easily look at your balance by days for any
month. Also, you can see statistics of income and
expense with useful information about your
frequent transactions and transaction categories.

# How to install?

### Pre-installation

You need standard libraries and programs for
any Laravel 9+ projects:

* PHP >= 8.0
* BCMath PHP Extension
* Ctype PHP Extension
* cURL PHP Extension
* DOM PHP Extension
* Fileinfo PHP Extension
* JSON PHP Extension
* Mbstring PHP Extension
* OpenSSL PHP Extension
* PCRE PHP Extension
* PDO PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension

Also, you need MySQL PHP extension. I think you can
use any relation database, but I test it only on MySQL.

### Application installation

1. Clone GitHub repository
2. Run `composer update`
3. Copy **.env.example** as **.env**
4. Configure database connection ([see Laravel docs](https://laravel.com/docs/9.x/database#configuration))
5. Run `php artisan key:generate` command
6. Run `php artisan migrate`

That's all!

# How to run?

With simple `php artisan serve` command. It runs
local PHP server on http://localhost:8000.

# Customizing

You have some options to customize application.

### Language

You can adapt application to any language you want.
All translation files placed in `/lang` directory.

Application use next files:

* `forms.php`
* `links.php`
* `month-calendar.php`
* `months.php`
* `tables.php`
* `transaction_types.php`

You can make directory under `/lang` with
language shortname. For example – `en`. And under that
directory you can place needed files.

Then to apply your translation you need to define
`locale` parameter in `/config/app.php` to
your directory name (`en`).

### Date format

In `/config/app.php` you can find `date_format`
parameter. It has `m/d/Y` value by default. You can
use build your own format using symbols from
[date format docs](https://www.php.net/manual/ru/datetime.format.php#refsect1-datetime.format-parameters).

### Money format

You can define your own money format, but it's not
simple like other customize options.

You need to make your own class that
extends `\App\Structures\Money` class and then realize
abstract methods.

After that we should explain to our application
that we want to use our own money format. For that you
need to go to the `\App\Services\Money` class and
set instantiation class in single `make` method.
