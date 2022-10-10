<?php

// TODO: check header: X-Hub-Signature

echo '<pre>';
echo "Start job...\n";

echo "\nGit pull\n";
exec('cd /var/www && git pull origin master 2>&1', $output);
print_r($output);
unset($output);

echo "\nComposer install\n";
exec('cd /var/www && composer install 2>&1', $output);
print_r($output);
unset($output);

echo "\nMigrate\n";
exec('php /var/www/artisan migrate --force 2>&1', $output);
print_r($output);
unset($output);

echo "\nClear Cache\n";
exec('php /var/www/artisan route:cache 2>&1', $output);
print_r($output);
unset($output);

echo '</pre>';
