
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
                <a class="navbar-brand" href="<?= base_url(); ?>home">Intelliate</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <?php foreach ($links as $link => $value):?>
                        <li> <a href="<?= $value['link']; ?>">
                                <i class="material-icons"><?= $value['icon']; ?></i>
                                        <?= $value['name']; ?>
                            </a>
                        </li>                                 
                    <?php endforeach; ?>                    
                </ul>
            </div>
        </div>
    </nav>