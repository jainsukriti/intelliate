<body>
    <div class="wrapper">
        <div class="sidebar" data-active-color="rose" data-background-color="black" data-image="<?= base_url(); ?>assets/img/sidebar-1.jpg">

            <div class="logo">
                <a href="#" class="simple-text">
                    Intelliate
                </a>
            </div>
            <div class="logo logo-mini">
                <a href="#" class="simple-text">
                    AI
                </a>
            </div>
            <div class="sidebar-wrapper">
                <div class="user">
                    <div class="photo">
                        <img src="<?= base_url(); ?>assets/img/faces/avatar.jpg" />
                    </div>
                    <div class="info">
                        <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                            <?= $this->session->userdata('logged_in')['full_name']; ?>
                            <b class="caret"></b>
                        </a>
                        <div class="collapse" id="collapseExample">
                            <ul class="nav">
                                <li>
                                    <a href="<?= base_url(); ?>user/action">User Operations</a>
                                </li>
                                <li>
                                    <a href="<?= base_url(); ?>user/logout">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="nav">
                    <li class="active">
                        <a href="<?= base_url(); ?>user/action">
                            <i class="material-icons">dashboard</i>
                            <p>Back to Home</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-minimize">
                        <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                            <i class="material-icons visible-on-sidebar-regular">more_vert</i>
                            <i class="material-icons visible-on-sidebar-mini">view_list</i>
                        </button>
                    </div>
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"> Group Info </a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">                            
                            <li class="dropdown">
                                <a href="dashboard.html#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">account_box</i>
                                    
                                    <p class="hidden-lg hidden-md">
                                        Profile
                                        <b class="caret"></b>
                                    </p>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?= base_url(); ?>user/action">User Operations</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url(); ?>user/logout">Logout</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>user/logout" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">power_settings_new</i>
                                    <p class="hidden-lg hidden-md">Logout</p>
                                </a>
                            </li>
                            <li class="separator hidden-lg hidden-md"></li>
                        </ul>
                    </div>
                </div>
            </nav>