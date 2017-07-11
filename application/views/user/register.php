    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page" filter-color="black">
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                            <form method="POST" id="regform" action="<?= base_url(); ?>ajax/register">
                                <div class="card card-login card-hidden">
                                    <div class="card-header text-center" data-background-color="green">
                                        <h3 class="card-title">Register</h3>
                                        <!--<div class="social-line">
                                            <a href="<?= base_url(); ?>guest/register" class="btn btn-just-icon btn-simple">
                                                Register</i>
                                            </a>                                            
                                        </div>-->
                                    </div>
                                    <div class="card-content">                                        
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">account_circle</i>
                                                </span>
                                                <input type="text" class="form-control" placeholder="Full name" autocomplete="off" name="full_name" required>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">email</i>
                                                </span>
                                                <input type="email" class="form-control" placeholder="Email" autocomplete="off" name="user_email" required>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">verified_user</i>
                                                </span>
                                                <input type="text" placeholder="Username" class="form-control" autocomplete="off" name="username" required />
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">fingerprint</i>
                                                </span>
                                                <input type="password" placeholder="Password" class="form-control" autocomplete="off" name="password" required />
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">fingerprint</i>
                                                </span>
                                                <input type="password" autocomplete="off" placeholder="Retype Password" class="form-control" name="cnf_password" required />
                                            </div>
                                            <!-- If you want to add a checkbox to this form, uncomment this code -->
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="optionsCheckboxes" checked> I agree to the
                                                    <a href="register.html#something">terms and conditions</a>.
                                                </label>
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
                            $("#regform").submit(function(e) {
                                var url = "<?php echo base_url(); ?>ajax/register"; 
                                e.preventDefault();
                                $.ajax({
                                   type: "POST",
                                   url: url,
                                   data: $("#regform").serialize(),
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
                                            showToast('top','center','Successfully Registered..<strong>Please Login!</strong>','success');
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

