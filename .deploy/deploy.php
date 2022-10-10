<?php

// TODO: check header: X-Hub-Signature

echo '<pre>';
echo "Start job...\n";

echo "\nGit pull\n";
exec('cd /var/www && git pull origin master 2>&1', $output);
print_r($output);

echo "\nComposer install\n";
exec('cd /var/www && composer install 2>&1', $output);
print_r($output);

echo "\nMigrate\n";
exec('php /var/www/artisan migrate --force > /dev/null 2>&1 &', $output);
print_r($output);

echo "\nClear Cache\n";
exec('php /var/www/artisan route:cache > /dev/null 2>&1 &', $output);
print_r($output);

echo '</pre>';
