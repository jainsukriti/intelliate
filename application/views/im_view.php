</head>
<style type="text/css">
    .chat-img
    {
        padding: 1% !important;
    }
    .chat-body
    {
        padding: 2% !important;
    }
</style>
<body>
<section id="content">
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bgm-lightgreen c-white">
                    <span class="glyphicon glyphicon-comment"></span>&nbsp;&nbsp;&nbsp;Chat with <strong><?= ucwords(strtolower($receiveruid)); ?></strong>

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
                                $ar = [$username, $receiveruid];
                                arsort($ar);
                                $result = implode('', $ar);


                                printf('<input type="hidden" id="loggedIn" value="true" />');
                                printf('<input type="hidden" id="sender" value="%s" />',$username);
                                printf('<input type="hidden" id="senderuid" value="%s" />',$p['uid']);
                                printf('<input type="hidden" id="receiver" value="%s" />',$receiver);
                                printf('<input type="hidden" id="receiveruid" value="%s" />',$receiveruid);
                                printf('<input type="hidden" id="chathash" value="%s" />',$result);
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
        
    </div>
</div>

</body>

</html>