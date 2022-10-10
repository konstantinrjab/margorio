<?php

// TODO: check header: X-Hub-Signature

echo "Start job...\n\n";

echo "Git pull\n\n";
exec('cd ../ && git pull origin master', $output);
print_r($output);

echo "Composer install\n\n";
exec('cd ../ && composer install', $output);
print_r($output);

echo "Migrate\n\n";
exec('php ../artisan migrate --force', $output);
print_r($output);

echo "Clear Cache\n\n";
exec('php ../artisan route:cache', $output);
print_r($output);

