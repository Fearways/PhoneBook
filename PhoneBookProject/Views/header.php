<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">My Phone Book</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav col-sm-3">
                    <?php if (\Framework\App::getInstance()->isLogged()) : ?>
                        <li><?php \Framework\FormViewHelper::init()
                                ->initLink()->setAttribute('href', '/PhoneNumber')->setValue('Phone Numbers')->create()
                                ->render() ?></li>
                    <?php endif; ?>
                </ul>
                <?php if (\Framework\App::getInstance()->isLogged()) : ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <?php
                            \Framework\FormViewHelper::init()
                                ->initForm('/PhoneNumber/search', ['class' => 'form-group'], 'post')
                                ->initTextBox()->setName('search')->setAttribute('id', 'search')->setAttribute('class', 'form-control input-md')->create()
                                ->initSubmit()->setAttribute('value', 'Search')->setAttribute('class', 'glyphicon glyphicon-search')->create()
                                ->render(); ?>

                        </li>
                        <li>
                            <?php Framework\FormViewHelper::init()
                                ->initLink()->setAttribute('href', '/user/logout')->setValue('Logout')->create()
                                ->render();
                                ?>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
</header>
