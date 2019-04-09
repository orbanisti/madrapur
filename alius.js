const shell = require('shelljs');

const fePath = './frontend/madrapur-fe';

shell
    .cd(fePath)
    .exec('git pull')
    .exec('npm run build');

shell.cd('../..');

shell
    .ls(fePath + '/docroot/react-bundle/*-script.js*')
    .forEach(
        (file) => {
            shell.cp('-R', file, './frontend/web/react-bundle');
        }
    );

shell
    .ls(fePath + '/docroot/react-bundle/*-style.css*')
    .forEach(
        (file) => {
            shell.cp('-R', file, './frontend/web/react-bundle');
        }
    );

shell.exec('webpack --progress');