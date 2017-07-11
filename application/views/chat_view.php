<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	<title>User Navigation Chat</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Portfolio project showing skills with Node.js, PHP, Javascript, jQuery, AJAX and API's">
	<meta name="author" content="Patrick Burns">
    <link href="<?php echo base_url(); ?>assets/chat/css/style.css" rel="stylesheet" type="text/css">        
	<link href="<?php echo base_url(); ?>assets/chat/css/jquery.jgrowl.css" rel="stylesheet" type="text/css">
        <script type="text/javascript">
            if (window.location.hash && window.location.hash == '#_=_') {
                if (window.history && history.pushState) {
                    window.history.pushState("", document.title, window.location.pathname);
                } else {
                    // Prevent scrolling by storing the page's current scroll offset
                    var scroll = {
                        top: document.body.scrollTop,
                        left: document.body.scrollLeft
                    };
                    window.location.hash = '';
                    // Restore the scroll offset, should be flicker free
                    document.body.scrollTop = scroll.top;
                    document.body.scrollLeft = scroll.left;
                }
            }
        </script>
</head>
<style type="text/css">
    .card-body
    {
    overflow-y: scroll;
    height: 400px;
    }
</style>
<body>
<section id="content">
    <div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bgm-lightgreen c-white">
                    <span class="glyphicon glyphicon-comment"></span> Chat
                </div>
                <div class="card-body card-padding">
                    <input type="hidden" id="pageNum" value="1" />
                        <?php 
                            if(!$this->session->userdata('logged_in')){
                                printf('<input type="hidden" id="loggedIn" value="false" />');
                            }
                            else{
                                $p = $this->session->userdata('logged_in');
                                $avatar = $p['avatar'];
                                $username = $p['username'];

                                printf('<input type="hidden" id="loggedIn" value="true" />');
                                printf('<input type="hidden" id="userName" value="%s" />',$username);
                                printf('<input type="hidden" id="avatar" value="%s" />', $avatar);
                            }
                        ?>
                    <ul class="chat">
                        <?php 
                            foreach($messageData as $message){
                                printf('%s', $message['messageHtml']);
                            }
                        ?>
                    </ul>
                </div>
                <div class="panel-footer">
                    <div id="messageInputGroup" class="input-group">
                        <input id="message" type="text" class="form-control input-sm" placeholder="Type your message here..." />
                        <span class="input-group-btn">
                            <button id="submitNewMessage" class="btn btn-warning btn-sm has-spinner"><span class="spinner"><i class="fa fa-refresh fa-spin"></i></span>Send</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bgm-green c-white">
                    <span class="glyphicon glyphicon-user"></span> Who's Online
                </div>
                <div class="card-body card-padding">
                    <ul class="user-list">
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>nodejs/node_modules/socket.io/node_modules/socket.io-client/socket.io.js"></script>
<script src="<?php echo base_url(); ?>assets/chat/js/plugins/jquery.jgrowl.min.js"></script>
<script src="<?php echo base_url(); ?>assets/chat/js/plugins/jquery.timeago.js"></script>
<script>
$( document ).ready(function() {
    $(".fancyTime").timeago();
    socket = io.connect('http://localhost:3080');
    
    socket.on('startup',function(users){
        sendJGrowlMessage('Connected to websocket server.', 'success');
        buildWhosOnlineHtml(users);
    });
    
    socket.on('newUserConnected', function(users){
        buildWhosOnlineHtml(users);
    });
        
    socket.on('updateChat', function (messageData) {
        $(messageData.messageHtml).appendTo('.chat');
        console.log(messageData.messageHtml);
        $(".fancyTime").timeago();
        $(".card-body").animate({ scrollTop: $('.card-body')[0].scrollHeight}, 1000);
    });
    
    socket.on('updateUsers', function(users){
       buildWhosOnlineHtml(users);
    });
        
    if($('#loggedIn').val() === 'true'){
        var data = new Object;
        data.username = $('#userName').val();
        data.avatar = $('#avatar').val();
        socket.emit('userConnected',  data);
    }
    
    $(".card-body").animate({ scrollTop: $('.card-body')[0].scrollHeight}, 1000);
    
    $('.card-body').on('scroll', function(){
        if ($(this).scrollTop() === 0) {
            var pageNum = parseInt($('#pageNum').val());
            $('#loadingMessage').remove();
            $('.chat').prepend('<li id="loadingMessage" class="left clearfix">'
                                    +'<div class="chat-body clearfix">'
                                        +'<div class="header">'
                                            +'<h4 style="text-align:center;"><i class="fa fa-refresh fa-spin"></i> Loading More Messages</h4>'
                                        +'</div>'
                                    +'</div>'
                                +'</li>');
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>message/getPaginated/' + pageNum,
                dataType: "json", 
                data: 'message=' + message, 
                success: function(data, textStatus, jqXHR){
                    if(data.status === "success"){
                        $('#loadingMessage').fadeOut('slow', function(){
                            $(this).remove();
                            $.each(data.messageData, function(index, message) { 
                                $('.chat').prepend(message.messageHtml);
                                $(".fancyTime").timeago();
                                $('.panel-body').scrollTop(300);
                            }); 
                            $('#pageNum').val(pageNum +1);
                        });
                    }
                }
            });
        }
    });
    
    $("#message").keypress(function (e) {
        if (e.keyCode === 13){
            submitMessage();
        }
    });


    $('#submitNewMessage').click(function(event){
        event.preventDefault();
        submitMessage();
    });
});

function submitMessage(){ 
    var message = $('#message').val();
    var loggedIn = $('#loggedIn').val();
    if(($('#submitNewMessage').hasClass('active')) || ($('#submitNewMessage').hasClass('shake'))){
        return false;
    }
    if(loggedIn === 'false'){
        $('#messageInputGroup').addClass('shake');
        sendJGrowlMessage('Please log in to join the conversation', 'error');
        setTimeout(
            function(){
                $('#messageInputGroup').removeClass('shake');
            }, 1000
        );
       return false;
    }
    if(message === ''){
        $('#messageInputGroup').addClass('shake');
        sendJGrowlMessage(' Please enter a message to submit', 'error');
        setTimeout(
            function(){
                $('#messageInputGroup').removeClass('shake');
            }, 1000
        );
        return false;
    }
    $('#submitNewMessage').toggleClass('active');
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>message/submit/',
        dataType: "json", 
        data: 'message=' + message, 
        success: function(data, textStatus, jqXHR){
            $('#message').val('');
            if(data.status === "success"){
                socket.emit('newMessage',  data);
            }
            else{
                sendJGrowlMessage(data.errormessage, 'error');
            }
        }       
    });
    setTimeout(
        function(){
            $('#submitNewMessage').toggleClass('active');
        }, 500
    );
}

function buildWhosOnlineHtml(users){
       $('.user-list').empty();
       $.each(users, function(index, user) { 
           console.log(user);
           $('<li class="left clearfix">'
                +'<span class="chat-img pull-left">'
                    +'<img src="<?= base_url(); ?>uploads/dp/thumbs/200x200/' + user.avatar + '" alt="User Avatar" class="img-circle"  style="margin-right:8px;"/>'
                +'</span>'
                +'<div class="chat-body clearfix">'
                    +'<div class="header">'
                        +'<strong class="primary-font">' + user.username + '</strong>'
                        +'<small class="pull-right  text-muted"><span class="glyphicon glyphicon-time"></span> <time class="fancyTime" datetime="' + user.isoDateTime + '"></time></small>'
                    +'</div>'
                    +'<p>'
                        +'<i class="fa fa-circle" style="color:green;"></i> Online'
                    +'</p>'
                +'</div>'
            +'</li>').appendTo('.user-list');
       }); 
       $(".fancyTime").timeago();
}

function sendJGrowlMessage(message, type){
    if(type === "error"){
        $.jGrowl('<i class="glyphicon glyphicon-ban-circle" style="color:red;font-size:14px;padding-right:3px;"></i>' + message, { position: 'bottom-right' }); 
    }
    else if(type === "success"){
        $.jGrowl('<i class="fa fa-check-circle" style="color:green;font-size:14px;padding-right:3px;"></i>' + message, { position: 'bottom-right' });
    }
}
</script>
</html>