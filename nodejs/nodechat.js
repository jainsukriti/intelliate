
// Express requires these dependencies
var express = require('express')
  , https = require('https')
  , fs = require('fs')
  , path = require('path');


var options = {
  key: fs.readFileSync('/etc/letsencrypt/archive/tomgeorge.me-0001/privkey3.pem'),
  cert: fs.readFileSync('/etc/letsencrypt/archive/tomgeorge.me-0001/fullchain3.pem')
};


var app = express();

  app.set('port', process.env.PORT || 443);  
  app.use(express.static(path.join(__dirname, 'public')));


// Enable Socket.io
var server = https.createServer(options, function(req, res){});
server.listen(8085, 'tomgeorge.me');

var io = require('socket.io').listen( server );
io.set('origins', '*:*');


console.log(io);

usernames = {};
hashBucket = {};

io.sockets.on('connection', function(socket){

    socket.emit('startup', usernames);
    socket.on('room', function(room) {
        socket.join(room);
    });

    socket.on('newMessage', function (data) {
        var sender = socket.username;
        var message = data.message;
        socket.broadcast.to(data.chathash).emit('updateChat',{name: sender, msg: data});
    });

    socket.on('title', function (data) {
        var sender = socket.username;
        var message = data.message;
        io.sockets.in(data).emit('title',data);
    });
    
    socket.on('userConnected', function(data){
        var isoDateTime = new Date();
        socket.username = data.username;
        data['status'] = 'online';
        data['isoDateTime'] = isoDateTime.toISOString();
        usernames[data.username] = data;
        hashBucket[data.username] = socket.id;
        io.sockets.emit('newUserConnected', usernames);
    });
    
    socket.on('disconnect', function(){
        // remove the username from global usernames list
        delete usernames[socket.username];
        delete hashBucket[socket.username];

        // update list of users in chat, client-side
        io.sockets.emit('updateUsers', usernames);
    });
});
