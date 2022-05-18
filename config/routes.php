<?php

return [
    "/category/<category:\w+>/page/<page:\d+>" => 'site/index',
    "/category/<category:\w+>" => 'site/index',
    "/page/<page:\d+>" => 'site/index',
    "/" => 'site/index',
    "login" => 'site/login',
    "logout" => 'site/logout',
    "signup" => 'site/signup',
    "news/<url:\w+>/page/<page:\d+>" => 'site/news',
    "news/<url:\w+>" => 'site/news',
    '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
    '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
];