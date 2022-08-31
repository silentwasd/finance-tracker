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
2. Copy **.env.example** as **.env**
3. Configure database connection ([see Laravel docs](https://laravel.com/docs/9.x/database#configuration))
4. Run `php artisan key:generate` command
5. Run `php artisan migrate`

That's all!

# How to run?

With simple `php artisan serve` command. It runs
local PHP server on http://localhost:8000.
