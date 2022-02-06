<?php


use App\Kernel;
require_once dirname(__DIR__).'/vendor/autoload_runtime.php'; ?>

<footer>
<a href="home">Home</a>
</footer>
<?php
return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
