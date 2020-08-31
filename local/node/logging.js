var winston = require('winston');
var { createLogger, format, transports } = winston;
var { combine, timestamp, label, printf } = format;
var fs = require('fs');
var path = require('path');
var dateFormat = require('dateformat');
var now = new Date();
var logDir = 'logs';
require('winston-daily-rotate-file');
require('express-async-errors');

// var logFile = path.join(logDir, 'logFile-%DATE%.log');
var logFile = path.join(logDir, 'logFile.log');
var uncaughtExceptions = path.join(logDir, 'uncaughtException.log');

// Create the log directory if it does not exist
if (!fs.existsSync(logDir)) {
    fs.mkdirSync(logDir);
}

var errorStackTracerFormat = winston.format(info => {
    info.full_trace = '';
    if (info.meta && info.meta instanceof Error) {
        info.full_trace = `: ${info.meta.stack}`;
    }
    return info;
});

var transport = new (winston.transports.DailyRotateFile)({
    filename: logFile,
    datePattern: 'YYYY-MM-DD',
    zippedArchive: false,
    json : true,
    maxSize: '20m',
    maxFiles: '14d'
});

transport.on('rotate', function (oldFilename, newFilename) {
    console.log(oldFilename, newFilename);
});

// var transport = new (winston.transports.File)({
//     filename : logFile,
//     maxsize : 1024 * 1024 * 500,
//     maxFiles : 10,
//     json : true,
//     tailable : true,
// });
// new winston.transports.File({ filename:logFile });
module.exports = function () {
    createLogger({
        level: 'info',
        format: combine(
            winston.format.splat(),
            errorStackTracerFormat(),
            label({ label: process.env.NODE_ENV || 'local' }),
            timestamp({
                format: dateFormat(now, "yyyy-mm-dd HH:MM:ss")
            }),
            printf(info => {
                return `[${info.timestamp}] ${info.label}.${info.level}: ${info.message} ${info.full_trace}`;
            })
        ),
        transports: [
            new transports.Console({
                handleExceptions: true,
            }),
            new transports.File({ filename: uncaughtExceptions, handleExceptions: true })
        ],
        exitOnError: false
    });

    process.on('unhandledRejection', (ex) => {
        throw ex;
    });

    winston.configure({
        format: combine(
            winston.format.splat(),
            errorStackTracerFormat(),
            label({ label: process.env.NODE_ENV || 'local' }),
            timestamp({
                format: dateFormat(now, "yyyy-mm-dd HH:MM:ss")
            }),
            printf(info => {
                return `[${info.timestamp}] ${info.label}.${info.level}: ${info.message} ${info.full_trace}`;
            })
        ),
        transports: [
            transport
        ]
    });
}