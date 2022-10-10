<?php

// TODO: check header: X-Hub-Signature

exec('git pull origin master');
exec('php ../artisan migrate --force');
exec('php ../artisan route:cache');
