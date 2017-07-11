<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Material Design Chat</title>
    <!--<script src="http://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>-->

<meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="<?= base_url(); ?>assets/mdchat/css/normalize.css">

    <link rel='stylesheet prefetch' href='https://s3-us-west-2.amazonaws.com/s.cdpn.io/104946/animate.min.css'>

        <link rel="stylesheet" href="<?= base_url(); ?>assets/mdchat/css/style.css">
    
  </head>

  <body>

    
<h1 class="title">Material Design Chat</h1>
<div class="wrapper">
  <nav id="nav" class="nav">
    <div class="default-nav">
      <div class="main-nav">
        <div class="toggle"></div>
        <div class="main-nav-item"><a href="<?= base_url(); ?>group/info/<?= $group_hash; ?>" class="main-nav-item-link"><?= $gName; ?></a></div>
        <div class="options"></div>
      </div>
    </div>
  </nav>
  <div id="inner" class="inner">
    <div id="content" class="content">
        <?php foreach ($messageData as $key => $value): ?>
            <div class="message-wrapper <?= $value['target']; ?>">
              <div class="avatar_card animated bounceIn"><img class="avatar_resize" src="<?= base_url(); ?>uploads/dp/thumbs/200x200/avatar.png"></div>
              <div class="text-wrapper animated fadeIn"><?= $value['message']; ?></div>
            </div>
        <?php endforeach; ?>            
    </div>
  </div>
  <div id="bottom" class="bottom">
    <input type="hidden" id="chathash" name="chathash" value="<?= $gId; ?>">
    <input type="hidden" id="sender" name="sender" value="<?= $sender; ?>">
    <textarea id="message" class="input"></textarea>
    <div id="send" class="send"></div>
  </div>
</div>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js" type="text/javascript"></script>

        <script src="<?= base_url(); ?>assets/mdchat/js/index.js"></script>

        <script src="https://tomgeorge.me:8085/socket.io/socket.io.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.2/jquery.jgrowl.js"></script>
<script src="<?php echo base_url(); ?>assets/chat/js/plugins/jquery.timeago.js"></script>

    <script>
$( document ).ready(function() {
    function scrollNext() {
    
    $("#inner").animate({ scrollTop: $('#inner')[0].scrollHeight}, 1000);
  }

    $(".fancyTime").timeago();
    socket = io.connect('https://tomgeorge.me:8085');
    
    socket.on('startup',function(users){
        //sendJGrowlMessage('Connected to websocket server.', 'success');
        buildWhosOnlineHtml(users);
        var sender = $('#chathash').val();
        var room = sender;
        socket.emit('room', room);
    });

    socket.on('title', function(data){

    $(document).attr("title", "typing");

    });
    
    socket.on('latest', function(data){
        alert (data);
    });
          
    socket.on('newUserConnected', function(users){
        buildWhosOnlineHtml(users);
    });
        
    socket.on('updateChat', function (messageData) {

        supposedUser = $("#receiver").val();
        supposedSender = $("#senderuid").val();

            $(messageData.msg.messageHtml).appendTo('#content');
            $(document).attr("title", "New message");
            scrollNext();

            $(".fancyTime").timeago();
            //$(".card-body").animate({ scrollTop: $('.card-body')[0].scrollHeight}, 1000);            
        

    });
    
    socket.on('updateUsers', function(users){
       buildWhosOnlineHtml(users);
    });
        
    if($('#loggedIn').val() === 'true'){
        var data = new Object;
        data.username = $('#sender').val();
        data.avatar = $('#avatar').val();
        data.receiver = $("#receiveruid").val();
        data.sender = $("#senderuid").val();
        data.chathash = $("#chathash").val();

        socket.emit('userConnected',  data);
    }
    
    //$(".content-body").animate({ scrollTop: $('.content-body')[0].scrollHeight}, 1000);
    
    $('.content-body').on('scroll', function(){
        if ($(this).scrollTop() === 0) {
            var pageNum = parseInt($('#pageNum').val());
            var receiver = $("#receiver").val();
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
                url: '<?php echo base_url(); ?>message/getPaginated/'+receiver+'/' + pageNum,
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
    
    $("#message").keyup(function (e) {
        if (e.keyCode === 13){
            submitMessage();
        }
    });


    $('#send').click(function(event){
        event.preventDefault();
        submitMessage();
    });
});


$( "#message" ).click(function() {
    var chathash = $("#chathash").val();
    //data.chathash = chathash;
    socket.emit('title', chathash);

});





function submitMessage(){ 
    var message = $('#message').val();
    var loggedIn = $('#loggedIn').val();
    var sender = $('#sender').val();
    var receiver = $('#chathash').val();

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
    var chathash = $("#chathash").val();

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>message/im/',
        dataType: "json", 
        data: 'message=' + message+'&receiver='+receiver, 
        success: function(data, textStatus, jqXHR){
            $('#message').val('');
            if(data.status === "success"){
                data.chathash = chathash;
                $(data.messageHtmlSelf).appendTo('#content');
                $("#inner").animate({ scrollTop: $('#inner')[0].scrollHeight}, 1000);
                socket.emit('newMessage', data); 

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
       var currentUser = 'tom';
       $.each(users, function(index, user) { 
            if (user.sender != currentUser) {
               $('<a href="<?= base_url(); ?>chat/user/'+ user.sender +'"><li class="left clearfix">'
                    +'<span class="chat-img pull-left" style="padding:1%;">'
                        +'<img style="width:50px" src="<?= base_url(); ?>uploads/dp/thumbs/200x200/' + user.avatar + '" alt="User Avatar" class="img-circle"  style="margin-right:8px;"/>'
                    +'</span>'
                    +'<div class="chat-body clearfix" style="padding:2%;">'
                        +'<div class="header">'
                            +'<strong class="primary-font">' + user.username + '</strong>'
                            +'<small class="pull-right  text-muted"><span class="glyphicon glyphicon-time"></span> <time class="fancyTime" datetime="' + user.isoDateTime + '"></time></small>'
                        +'</div>'
                        +'<p>'
                            +'<i class="fa fa-circle" style="color:green;"></i> Online'
                        +'</p>'
                    +'</div>'
                +'</li></a>').appendTo('.user-list');                
            };
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
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
        console.log('Test');
    } else {
        console.log("Geolocation is not supported by this browser.");
    }
}
function showPosition(position) {
    console.log(position.coords.latitude);
    console.log(position.coords.longitude);
    $.post( "<?= base_url(); ?>ajax/locaton_ping", { lat: position.coords.latitude, lng: position.coords.longitude } );
}
getLocation();
</script>
    
    
  </body>
</html>
