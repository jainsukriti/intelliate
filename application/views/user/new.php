
<body>
    <nav class="navbar navbar-primary navbar-transparent navbar-absolute">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../dashboard.html">Intelliate</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="../dashboard.html">
                            <i class="material-icons">dashboard</i> Info
                        </a>
                    </li>
                    <li class="">
                        <a href="register.html">
                            <i class="material-icons">person_add</i> Register
                        </a>
                    </li>
                    <li class="">
                        <a href="login.html">
                            <i class="material-icons">fingerprint</i> Terms
                        </a>
                    </li>
                    <li class="">
                        <a href="lock.html">
                            <i class="material-icons">lock_open</i> Privacy
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="wrapper wrapper-full-page">
        <div class="full-page lock-page" filter-color="black" >
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            <div class="content">
                <form method="#" action="lock.html#">
                    <div class="card card-profile">
                        <div class="card-avatar">
                            <a href="lock.html#pablo">
                                <img class="avatar" src="<?= base_url(); ?>assets/img/faces/avatar.jpg" alt="...">
                            </a>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">{User-Name}</h4>
                            <div class="form-group label-floating is-empty">
                                <label class="control-label">Group Hash</label>
                                <input type="text" class="form-control">
                            <span class="material-input"></span></div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-success btn-round">Join</button>
                        </div>
                    </div>
                </form>
            </div>
            <footer class="footer">
                <div class="container">                    
                    <p class="copyright pull-right">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <a href="#">Intelliate</a>, Project done by Amal &amp; Tom
                    </p>
                </div>
            </footer>
        </div>
    </div>
</body>

