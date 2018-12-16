<?php

namespace Deployer;

require 'recipe/symfony4.php';

inventory('host.yaml');

set('application', 'La boite à beauf');
set('repository', 'git@github.com:kevin-verschaeve/boite-a-beauf.git');
set('git_tty', true);
set('writable_mode', 'chmod');
set('shared_files', ['var/bab.sqlite', 'var/authorized_ips.json']);
// todo : make the deploy work without precising env vars here (already present in the vhost)
set('env', [
    'APP_ENV' => 'prod',
    'DATABASE_URL' => 'sqlite:///%kernel.project_dir%/var/bab.sqlite',
    'PLAYER_COMMAND' => 'omxplayer -o local',
    'IP_FILE' => '%kernel.project_dir%/var/authorized_ips.json',
]);

task('database:migrate', function () {
    run('{{bin/console}} bab:db:update');
})->desc('Updating database');

after('deploy:failed', 'deploy:unlock');
before('deploy:symlink', 'database:migrate');
