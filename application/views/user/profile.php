
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-profile">
                    <div class="card-avatar">
                        <a href="user.html#pablo">
                            <img class="img" src="<?= base_url(); ?>uploads/dp/thumbs/200x200/<?= $user['avatar']; ?>" />
                        </a>
                    </div>
                    <div class="card-content">
                        <h6 class="category text-gray">@<?= $user['username']; ?></h6>
                        <h4 class="card-title"><?= $user['full_name']; ?></h4>                        
                        <div class="row">
                            <h2>Sensor Readings</h2>
                            <div class="col-lg-6 col-md-5 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header" data-background-color="orange">
                                        <i class="material-icons">hearing</i>
                                    </div>
                                    <div class="card-content">
                                        <strong><p class="category">Sound</p></strong>
                                        <h3 class="card-title dyn_c" id="iot_sound"></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-5 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header" data-background-color="rose">
                                        <i class="material-icons">wb_sunny</i>
                                    </div>
                                    <div class="card-content">
                                        <strong><p class="category">Light</p></strong>
                                        <h3 class="card-title dyn_c" id="iot_light"></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-5 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header" data-background-color="red">
                                        <i class="material-icons">favorite</i>
                                    </div>
                                    <div class="card-content">
                                        <strong><p class="category">Heart Beat</p></strong>
                                        <h3 class="card-title dyn_c" id="iot_heartbeat"></h3>
                                    </div>                                    
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-5 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header" data-background-color="blue">
                                        <i class="material-icons">cloud</i>
                                    </div>
                                    <div class="card-content">
                                        <strong><p class="category">Humidity</p></strong>
                                        <h3 class="card-title dyn_c" id="iot_humidity"></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-5 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header" data-background-color="black">
                                        <i class="fa fa-thermometer-three-quarters" aria-hidden="true"></i>
                                    </div>
                                    <div class="card-content">
                                        <strong><p class="category">Temperature</p></strong>
                                        <h3 class="card-title dyn_c" id="iot_temp"></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-5 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header" data-background-color="black">
                                        <i class="material-icons">room</i>
                                    </div>
                                    <div class="card-content">
                                        <strong><p class="category">Location</p></strong>
                                        <h4 class="card-title">Lat : <?= substr($user['user_lat'], 0,7); ?></h4>
                                        <h4 class="card-title">Lng : <?= substr($user['user_lng'], 0,7); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button id="fetch_new" class="btn btn-rose btn-round">Refresh Sensor Data</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="rose">
                        <i class="material-icons">perm_identity</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Edit Profile -
                            <small class="category">Complete your profile</small>
                        </h4>
                        <form>
                            <div class="row">                                
                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Username</label>
                                        <input type="text" value="<?= $user['username']; ?>" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Email address</label>
                                        <input type="email" value="<?= $user['user_email']; ?>" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Full Name</label>
                                        <input type="text" name="full_name" pattern="[A-Z a-z]*" value="<?= $user['full_name']; ?>" class="form-control" autocomplete="off" title="Only Alphabets">
                                    </div>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Phone</label>
                                        <input type="text" pattern="\d*" name="phone" maxlength="10"  class="form-control" title="Digits Only">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">City</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Country</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Postal Code</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>About Me</label>
                                        <div class="form-group label-floating">
                                            <label class="control-label"> Lamborghini Mercy, Your chick she so thirsty, I'm in that two seat Lambo.</label>
                                            <textarea class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-rose pull-right">Update Profile</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>

<script type="text/javascript">
$("#fetch_new").click(function(){
    $(".dyn_c").html("<i class=\"fa fa-circle-o-notch fa-spin fa-fw \" aria-hidden=\"true\"></i>");
     $.get( "<?= base_url(); ?>ajax/getIoTDataRecent", function (data) {
          var json = JSON.parse(data);
          console.log(json);
          $(".dyn_c").html("");
          $("#iot_temp").html(json.temperature);
          $("#iot_sound").html(json.audio);
          $("#iot_heartbeat").html(json.heartBeat);
          $("#iot_light").html(json.lightIntensity);
          $("#iot_humidity").html(json.humidity);
        }); 
});
   
</script>