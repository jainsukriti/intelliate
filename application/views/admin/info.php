
            <div class="content">
                <div class="container-fluid">            
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">room</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Groups and Members</h4>
                                    <!--<?php print_r($group_data); ?>-->
                                    <?php foreach ($group_data as $group_name => $members_data): ?>
                                        <div class="row">                                                                 
                                            <div class="card-content">                            
                                            <h4 class="card-title">
                                                <div class="card">                                                
                                                    <i class="fa fa-users" aria-hidden="true"></i> 
                                                    <?php echo $group_name; ?> 
                                                        <a class="btn btn-just-icon btn-simple btn-warning" href="<?= base_url(); ?>group/info/<?= $group_data[$group_name][0]['vanity'] ?>">
                                                            <i class="material-icons">info</i>
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                </div>                
                                            </h4>
                                            <?php foreach ($members_data as $key => $member): ?>
                                            <div class="col-lg-4 col-md-6 col-sm-6">                            
                                                <div class="card card-stats">
                                                    <div class="card-header" data-background-color="orange">
                                                        <i class="material-icons">weekend</i>
                                                    </div>
                                                    <div class="card-content">
                                                        <p class="category"><?= $member['username']; ?></p>
                                                        <h3 class="card-title"><?= $member['full_name']; ?></h3>
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="stats">
                                                            <i class="material-icons text-danger">warning</i>
                                                            <a href="<?= base_url(); ?>user/view/<?= $member['username']; ?>">Get User Info...</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                            
                                            <?php endforeach; ?>  
                                            </div>     
                                        </div>                                 
                                    <?php endforeach ?>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            