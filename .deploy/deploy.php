<?php

// TODO: check header: X-Hub-Signature

exec('cd ../ && git pull origin master', $output);
print_r($output);

exec('cd ../ && composer install', $output);
print_r($output);

exec('php ../artisan migrate --force', $output);
print_r($output);

exec('php ../artisan route:cache', $output);
print_r($output);

