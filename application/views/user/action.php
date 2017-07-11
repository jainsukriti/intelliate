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
                  <h4 class="card-title">Welcome back, <strong> <?= $this->session->userdata('logged_in')['full_name']; ?></strong></h4>
                  <div class="col-lg-12 col-md-10 col-sm-2">
                    <h3 class="title text-center">Choose an Option to proceed</h3><br>
                    <div class="nav-center">
                      <ul class="nav nav-pills nav-pills-success nav-pills-icons" role=
                      "tablist">
                        <li>
                          <a data-toggle="tab" href="#create" role="tab"><i class=
                          "material-icons">description</i> New Group</a>
                        </li>
                        <li class="active">
                          <a data-toggle="tab" href="#join" role="tab"><i class=
                          "material-icons">location_on</i> Join Group</a>
                        </li>
                        <li>
                          <a data-toggle="tab" href="#view" role="tab"><i class=
                          "material-icons">perm_device_information</i>My Groups</a>
                        </li>
                        <li>
                          <a data-toggle="tab" href="#help" role="tab"><i class=
                          "material-icons">help</i> Help</a>
                        </li>
                      </ul>
                    </div>
                    <div class="tab-content">
                      <div class="tab-pane" id="create">
                        <div class="card">
                          <div class="card-header">
                            <h4 class="card-title">Fill Your Group Information</h4>
                          </div>
                          <div class="card-content">
                            <form action="#" method="POST" id="groupCreate">
                              <div class="form-group">
                                <label for="groupCategory"> Group Category</label>
                                <select class="selectpicker" name="gCategory" data-size="7" data-style=
                                "select-with-transition" title="Choose Category">
                                  <option disabled>
                                    Choose Category
                                  </option>
                                  <option value="Secret Mission">
                                    Secret Mission
                                  </option>
                                  <option value="Dummy Mission">
                                    Dummy Mission
                                  </option>
                                  <option value="Normal Mission">
                                    Normal Mission
                                  </option>   
                                  <option value="Test Mission">
                                    Test Mission
                                  </option>
                                  <option value="Local Mission">
                                    Local Mission
                                  </option>
                                  <option value="Town Mission">
                                    Town Mission
                                  </option>
                                  <option value="City Mission">
                                    City Mission
                                  </option>
                                  <option value="Terrorist Mission">
                                    Terrorist Mission
                                  </option>                             
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="groupName"> Group Name</label>                                                                    
                                <input placeholder="Enter Group Name" class="form-control" type="text" name="gName" autocomplete="off" required="true" />
                              </div> 

                              <div class="form-group">
                                <label for="groupName"> Group Vanity</label>                                                                    
                                <input placeholder="Enter Group Custom URL" class="form-control" type="text" autocomplete="off" name="gVanity"/>
                              </div> 

                              <div class="form-group">
                                <button class="btn btn-danger btn-round" type="submit">Create Group</button>
                              </div>  
                            </form>                             
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane active" id="join">
                        <div class="card">
                          <div class="card-header">
                            <h4 class="card-title">Enter the Group ID to Continue</h4>
                          </div>
                          <div class="card-content">
                            <form action="" method="post" id="groupJoin">
                              <input class="form-control text-center" placeholder=
                              "Enter Group Hash" name="gHash" autocomplete="off" type="text"> <span class=
                              "material-input"></span> <button class=
                              "btn btn-danger btn-round" type="submit">Join</button>
                            </form>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane" id="view">
                        <div class="card">
                          <div class="card-content">
                            <div class="">
                              <div class="panel panel-success">
                                <div class="panel-heading">
                                  <h4><strong>Tap on Group to Open Chat</strong></h4>
                                </div>
                                <div class="panel-body">
                                  <table class="table table-bordered table-rounded">
                                    <tbody>
                                      <tr><td colspan="2"><strong>Groups You Manage</strong></td></tr>
                                      <?php foreach ($owner_groups as $key => $value): ?>
                                      <tr>
                                        <td class="text-left">
                                          <a href="<?= base_url();  ?>group/<?= $value['vanity']; ?>"><strong><?= $value['group_name']; ?> { <?= $value['group_category']; ?> }</strong></a>
                                        </td>
                                        <td class="td-actions text-center"><button class=
                                        "btn btn-primary btn-simple btn-xs" rel="tooltip" title=
                                        "Edit Group" type="button"><i class=
                                        "material-icons">edit</i></button> <button class=
                                        "btn btn-danger btn-simple btn-xs" rel="tooltip" title=
                                        "Leave Group" type="button"><i class=
                                        "material-icons">close</i></button></td>
                                      </tr>
                                    <?php endforeach; ?>
                                      <tr><td colspan="2"><strong>Your Groups</strong></td></tr>
                                      
                                      <?php foreach ($member_groups as $key => $value): ?>
                                      <tr>
                                        <td class="text-left">
                                          <a href="<?= base_url();  ?>group/<?= $value['vanity']; ?>"><strong><?= $value['group_name']; ?> { <?= $value['group_category']; ?> }</strong></a>
                                        </td>
                                        <td class="td-actions text-center"> <button class=
                                        "btn btn-danger btn-simple btn-xs" rel="tooltip" title=
                                        "Leave Group" type="button" id="leave_group" data-gid="<?= $value['group_id']; ?>"><i class=
                                        "material-icons">close</i></button></td>
                                      </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane" id="help">
                        <div class="card">
                          <div class="card-header">
                            <h4 class="card-title">Legal info of the product</h4>
                            <p class="category">More information here</p>
                          </div>
                          <div class="card-content">
                            Completely synergize resource taxing relationships via premier
                            niche markets. Professionally cultivate one-to-one customer
                            service with robust ideas.<br>
                            <br>
                            Dynamically innovate resource-leveling customer service for state
                            of the art customer service.
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <hr>
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

                            $("#groupJoin").submit(function(e) {
                                var url = "<?php echo base_url(); ?>ajax/groupJoin"; 
                                e.preventDefault();
                                $.ajax({
                                   type: "POST",
                                   url: url,
                                   data: $("#groupJoin").serialize(),
                                   success: function(data)
                                   {
                                        e.preventDefault();
                                        var json = $.parseJSON(data);

                                        console.log(json);

                                        if (json.status == 'ok') {                                            
                                            showToast('top','center',json.message,'success');
                                           ;
                                        }                         
                                        else{
                                            showToast('top','center',json.message,'danger');
                                        }                   
                                   }
                                });                                
                            });

                            $("#leave_group").click(function(e) {
                                var url = "<?php echo base_url(); ?>ajax/groupLeave"; 
                                e.preventDefault();
                                 var gid = $("#leave_group").attr('data-gid');
                                $.ajax({
                                   type: "POST",
                                   url: url,
                                   data: {group_id: gid},
                                   success: function(data)
                                   {
                                        e.preventDefault();
                                        var json = $.parseJSON(data);

                                        console.log(json);

                                        if (json.status == 'ok') {                                            
                                            showToast('top','center',json.message,'success');
                                           ;
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