<?php

use Sredni\Registry\Registry;

Registry::set('/facebook/app/key', 'YOUR_APP_KEY');
Registry::set('/facebook/app/secret', 'YOUR_APP_SECRET');
Registry::set('/facebook/app/access_token', 'YOUR_ACCESS_TOKEN');
Registry::set('/connection/amqp/default/host', 'localhost');
Registry::set('/connection/amqp/default/port', 5672);
Registry::set('/connection/amqp/default/user', 'guest');
Registry::set('/connection/amqp/default/password', 'guest');
Registry::set('/connection/amqp/default/queue', 'facebook_crawler');

Registry::set('/consumer/queues', [
    Registry::get('/connection/amqp/default/queue')
]);

