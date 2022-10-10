<?php

// TODO: check header: X-Hub-Signature

exec('cd ../ && git pull origin master');
exec('cd ../ && composer install');
exec('php ../artisan migrate --force');
exec('php ../artisan route:cache');
