var winston = require('winston');
var stack = null;
module.exports = function (err, req, res, next) {
    winston.error(err.message, err);
    // error
    // warn
    // info
    // verbose
    // debug 
    // silly
    
    try {
        stack = new Error().stack;
    } catch (error) {}
    next();
}