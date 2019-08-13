const shell = require('shelljs');
const basePath = './backend/modules/';
const modulePath = process.argv[2];
const buildPath = '/build/static';

const path = basePath + modulePath + buildPath;

shell
    .ls(path + '/js/*.js*')
    .forEach(
        (file) => {
            shell.cp('-R', file, './backend/web/react-bundle');
        }
    );

shell
    .ls(path + '/css/*.css*')
    .forEach(
        (file) => {
            shell.cp('-R', file, './backend/web/react-bundle');
        }
    );

shell.exec('webpack --progress --config webpack.config.backend.js');