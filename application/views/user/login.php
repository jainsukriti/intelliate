
    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page" filter-color="black" >
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            <div class="content">                
                <div class="container">

                    <div class="row">                        

                        <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                                 <?php echo $this->session->flashdata('msg'); ?>
                            <form id="loginform" method="POST" action="<?= base_url(); ?>ajax/login">
                                <div class="card card-login card-hidden">
                                    <div class="card-header text-center" data-background-color="green">                                    
                                        <h3 class="card-title">Login</h3>
                                        <!--<div class="social-line">
                                            <a href="<?= base_url(); ?>guest/register" class="btn btn-just-icon btn-simple">
                                                Register</i>
                                            </a>                                            
                                        </div>-->
                                    </div>
                                    <div class="card-content">             

                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">email</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Email address or Username</label>
                                                <input type="text" class="form-control" name="username" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Password</label>
                                                <input type="password" class="form-control" name="password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer text-center">
                                        <button type="submit" class="btn btn-success btn-md">Let's go</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container">                    
                    <p class="copyright pull-right">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <script>                           
                            //document.write(new Date().getFullYear());
                            function showToast(from, align, payload_message, color){
                                $.notify({
                                    icon: "notifications",
                                    message: payload_message

                                },{
                                    type: color,
                                    timer: 3000,
                                    placement: {
                                        from: from,
                                        align: align
                                    }})
                            }
                            $("#loginform").submit(function(e) {
                                var url = "<?php echo base_url(); ?>ajax/login"; 
                                e.preventDefault();
                                $.ajax({
                                   type: "POST",
                                   url: url,
                                   data: $("#loginform").serialize(),
                                   success: function(data)
                                   {
                                        e.preventDefault();
                                        var nFrom = 'top';
                                        var nAlign = 'center';
                                        var nIcons = $(this).attr('data-icon');
                                        var nType = 'success';
                                        var nAnimIn = $(this).attr('data-animation-in');
                                        var nAnimOut = $(this).attr('data-animation-out');
                                        var json = $.parseJSON(data);

                                        console.log(json);

                                        if (json.status == 'ok') {                                            
                                            showToast('top','center','Login Success.. Redirecting..','success');
                                            window.location.href ="<?= base_url(); ?>user/action";
                                        }                         
                                        else{
                                            showToast('top','center',json.message,'danger');
                                        }                   
                                   }
                                });                                
                            });
                        </script>
                        <a href="#">Intelliate</a>, Project done by Amal &amp; Tom
                    </p>
                </div>
            </footer>
        </div>
    </div>
</body>

