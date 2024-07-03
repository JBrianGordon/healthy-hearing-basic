<?php
namespace Deployer;

require 'recipe/common.php';

//*******************\\
//***** Config ******\\
//-------------------\\

// Dev site
$devUrl = 'DEV_URL';
$devAlias = 'DEV_ALIAS';
$devDeployPath = '/DEV/DEPLOY/PATH';

// CA-Dev site
$caDevUrl = 'CA_DEV_URL';
$caDevAlias = 'CA_DEV_ALIAS';
$caDevDeployPath = '/CA/DEV/DEPLOY/PATH';

// SSH settings
$remoteUser = 'REMOTE_USER';
$identityFile = '~/.ssh/IDENTITY_FILE';

set('repository', 'git@github.com:GIT_ORG/GIT_REPO.git');
set('keep_releases', 3);

//*******************\\
//****** Hosts ******\\
//-------------------\\

host($devUrl)
    ->set('remote_user', $remoteUser)
    ->set('identity_file', $identityFile)
    ->set('ssh_multiplexing', false)
    ->set('deploy_path', $devDeployPath)
    ->setLabels([
        'system' => $devAlias
    ]);

host($caDevUrl)
    ->set('remote_user', $remoteUser)
    ->set('identity_file', $identityFile)
    ->set('ssh_multiplexing', false)
    ->set('deploy_path', $caDevDeployPath)
    ->setLabels([
        'system' => $caDevAlias
    ]);


//*******************\\
//****** Tasks ******\\
//-------------------\\

task('build', function () {
    cd('{{release_path}}');
    run('bin/cake bootstrap install --latest');
    run('npm install');
    run('npm run build');
    run('npm run compile-sass');
});


//*******************\\
//****** Hooks ******\\
//-------------------\\

after('deploy:vendors', 'build');
after('deploy:failed', 'deploy:unlock');


//************************************************\\
//*** CakePHP 4 Project Template configuration ***\\
//------------------------------------------------\\

// CakePHP 4 Project Template shared dirs
set('shared_dirs', [
    'logs',
    'tmp',
]);

// CakePHP 4 Project Template shared files
set('shared_files', [
    'config/.env',
    'config/app.php',
    'config/app_local.php'
]);

/**
 * Create plugins' symlinks // ------ SEE NOTE BELOW IN 'deploy' TASK
 */
task('deploy:init', function () {
    run('{{bin/php}} {{release_or_current_path}}/bin/cake.php plugin assets symlink');
})->desc('Initialization');

/**
 * Run migrations
 */
task('deploy:run_migrations', function () {
    run('{{bin/php}} {{release_or_current_path}}/bin/cake.php migrations migrate --no-lock');
    run('{{bin/php}} {{release_or_current_path}}/bin/cake.php schema_cache build');
})->desc('Run migrations');

/**
 * Main task
 */
task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    // 'deploy:init',// temporarily? unused,symlink already in repo causing issue
    'deploy:run_migrations',
    'deploy:publish',
])->desc('Deploy your project');
