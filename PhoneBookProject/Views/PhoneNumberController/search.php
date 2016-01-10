<div class="row">
    <?php
    foreach ($this->_viewBag['body']->getPhoneNumber() as $PhoneNumber) :?>
        <div class="blueish panel panel-info col-md-5 margin-right">
            <div class="panel-body">

                <div class="row">
                    <p class="text-left">Name: <?= $PhoneNumber->getName() ?></p>
                </div>
                <div class="row">
                    <p class="text-left">Phone Number: <?= $PhoneNumber->getPhoneNumber() ?></p>
                </div>
                <div class="row">
                    <a class="col-sm-4 panel panel-danger btn btn-default text-center"
                       href="/PhoneNumber/editPhoneNumber/<?= $PhoneNumber->getId() ?>/edit">Edit PhoneNumber</a>
                    <div class="col-sm-4"></div>
                    <a class="col-sm-4 panel panel-danger btn btn-default text-center"
                       href="/PhoneNumber/removePhoneNumber/<?= $PhoneNumber->getId() ?>/remove">Remove</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

</div>
<div class="height">
</div>