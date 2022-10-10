<?php

// TODO: check header: X-Hub-Signature

echo '<pre>';
echo "Start job...\n";

echo "\nGit pull\n";
exec('cd /var/www && git pull origin master', $output);
print_r($output);

echo "\nComposer install\n";
exec('cd /var/www && composer install', $output);
print_r($output);

echo "\nMigrate\n";
exec('php /var/www/artisan migrate --force', $output);
print_r($output);

echo "\nClear Cache\n";
exec('php /var/www/artisan route:cache', $output);
print_r($output);

echo '</pre>';
