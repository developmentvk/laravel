const express = require('express');
const http = require('http');
const socketIO = require('socket.io');
const { json } = require('express');
const cors = require('cors');
require(__dirname + '/node/logging')();
var error = require(__dirname + '/node/error');
require('dotenv').config({
    path: __dirname + '/.env'
});
var User = require(__dirname + '/node/model.js');
const SOCKET_PORT = process.env.SOCKET_PORT;
const REDIS = {
    "host": process.env.REDIS_HOST,
    "port": process.env.REDIS_PORT,
    // "password": process.env.REDIS_PASSWORD,
    "family": 4
};
const port = process.env.PORT || SOCKET_PORT;
const app = express();
const server = http.createServer(app);
const io = socketIO(server);

app.set('trust proxy', true);
app.use(cors());
app.options('*', cors()); // include before other routes 
server.listen(port, function (err) {
    console.log(server.address());
    console.log('Server is running on port ' + port + '');
});
io.use(function (socket, next) {
    console.log("Request Received : ", socket.handshake.query);
    if (socket.handshake.query && socket.handshake.query.user_id) {
        User.getUserById(socket.handshake.query.user_id, function (err, task) {
            if (err) return next(new Error('Authentication error'));
            socket.decoded = JSON.parse(JSON.stringify(task))[0];
            next();
        });
    } else {
        next(new Error('Authentication error'));
    }
}).on('connection', function (socket) {
    console.log(socket.decoded.id);
    // 'Online','Offline'
    User.updateById(socket.decoded.id, "Online", new Date(), function (err, task) {
        // console.log(err, task);
        console.log('Connection now authenticated to receive further events');
    });

    socket.on('disconnect', function () {
        if (socket.decoded.id) {
            User.updateById(socket.decoded.id, "Offline", new Date(), function (err, task) {
                // console.log(err, task);
                console.log('Connection disconnected');
            });
        }
    });
});


// User.getUserById(function (err, task) {
//     console.log('controller')
//     if (err) {
//         res.send(err);
//     }
//     console.log('res', task);
// });

try {
    var ioredis = require('ioredis');
    var redis = new ioredis(REDIS);
    console.log('Connect to Redis server on port ' + REDIS.port);
} catch (err) {
    console.log('Cannot connect to Redis server on SOCKET_PORT ' + REDIS.SOCKET_PORT);
    throw new Error(err);
}

try {
    redis.psubscribe('*', function (error, count) {
        console.log('Server is listening for broadcasted messages');
    });

    redis.on('pmessage', function (subscribed, channel, data) {
        jsonData = JSON.parse(data);
        console.log('event:', jsonData.data.message.event, 'payloads:', jsonData.data.message.payloads);
        io.to(`trafficUpdate`).emit(jsonData.data.message.event, jsonData.data.message.payloads);
    });
} catch (err) {
    throw new Error(err);
}
app.use(error);