const { exec } = require("child_process");

const server = 'yarn pm2 start "php artisan serve --port 8080"';
const worker = 'yarn pm2 start "php artisan queue:work"';

const commands = [
    server,
    worker,
];
commands.map( item => {
    exec(item, (error, stdout, stderr) => {
        if (error) {
            console.log(`error: ${error.message}`);
            return;
        }
        if (stderr) {
            console.log(`stderr: ${stderr}`);
            return;
        }
        console.log(`stdout: ${stdout}`);
    });
});

