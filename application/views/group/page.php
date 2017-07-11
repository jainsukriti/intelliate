<div class="wrapper wrapper-full-page">
    <div class="full-page login-page">
      <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
      <div class="content">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="card card-profile card-hidden">
                <div class="card-avatar">
                  <a href="lock.html#pablo"><img alt="..." class="avatar" src=
                  "<?= base_url(); ?>assets/img/faces/avatar.jpg"></a>
                </div>
                <div class="card-content">
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
                                printf('<input type="hidden" id="sender" value="%s" />',$username);
                                printf('<input type="hidden" id="senderuid" value="%s" />',$p['uid']);
                                printf('<input type="hidden" id="receiver" value="%s" />',$group_hash);
                                printf('<input type="hidden" id="receiveruid" value="%s" />',$group_hash);
                                printf('<input type="hidden" id="chathash" value="%s" />',$group_hash);
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
                <div class="card-footer">
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
      </div>
      <footer class="footer">
        <div class="container">
          <p class="copyright pull-right">&copy; 
          <script>
                document.write(new Date().getFullYear())
          </script> 
          <script type="text/javascript">
            $("#groupCreate").submit(function(e) {
                                var url = "<?php echo base_url(); ?>ajax/groupNew"; 
                                e.preventDefault();
                                $.ajax({
                                   type: "POST",
                                   url: url,
                                   data: $("#groupCreate").serialize(),
                                   success: function(data)
                                   {
                                        e.preventDefault();
                                        var json = $.parseJSON(data);

                                        console.log(json);

                                        if (json.status == 'ok') {                                            
                                            showToast('top','center',json.vanity,'success');
                                            
                                        }                         
                                        else{
                                            showToast('top','center',json.message,'danger');
                                        }                   
                                   }
                                });                                
                            });
          </script>
          <a href="#">Intelliate</a>, Project done by Amal &amp; Tom</p>
        </div>
      </footer>
    </div>
  </div>
</body>