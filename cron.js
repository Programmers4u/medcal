const log = require('simple-node-logger').createSimpleLogger('pm2-cron.log');
const cron = require('node-cron');
const { exec } = require("child_process");

const CRON_TAB = '* * * * *';
cron.schedule(CRON_TAB, () => {
    log.info('running a task with ' + CRON_TAB + ' schem');
    let command = 'php artisan schedule:run >> /dev/null 2>&1';
    exec(command, (error, stdout, stderr) => {
        if (error) {
            log.error(`error: ${error.message}`);
            return;
        }
        if (stderr) {
            log.info(`stderr: ${stderr}`);
            return;
        }
        log.info(`stdout: ${stdout}`);
    });
});