const chDir = require('chdir');
const colors = require('colors');
const shell = require('shelljs');
const spawn = require('child_process').spawn;

const fePath = './frontend/madrapur-fe';

shell
    .cd(fePath)
    .exec('git pull')
    .exec('npm run build');

shell.cd('../..');

shell
    .ls(fePath + '/docroot/assets/134160ae/*-script.js*')
    .forEach(
        (file) => {
            shell.cp('-R', file, './frontend/web/js');
        }
    );

shell
    .ls(fePath + '/docroot/assets/134160ae/*-style.css*')
    .forEach(
        (file) => {
            shell.cp('-R', file, './frontend/web/css');
        }
    );

//shell.cp('-R', fePath + '/docroot/assets', './frontend/web/bundle');

shell.exec('webpack --progress');