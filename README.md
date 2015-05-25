Facebook crawler
=====================

Requirements:
-------------

php 5.5 - http://php.net
<br>
php-amqp - http://php.net/manual/pl/book.amqp.php
<br>
composer - http://getcomposer.org/

Installation:
-------------

```sh
git clone https://github.com/sredni/facebook_crawler.git
cd facebook_crawler
composer install
```

Run file parse:
---------------

```sh
./app.php parse-file <queue_name> <file_path>
```

Run consumer:
-------------

```sh
./app.php consume <queue_name>
```

Note: \<queue_name\> must be defined in config!
