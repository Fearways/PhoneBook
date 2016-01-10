<?php
if($_SESSION['error']!==null)
{
    \Framework\FormViewHelper::init()
        ->initDiv()->setValue($_SESSION['error'])->setAttribute('class','panel panel-danger text-center')->create()->render();
    $_SESSION['error']=null;
}
$_SESSION['error']=null;
?>
<div class="panel panel-primary  col-sm-6 col-sm-offset-3">
    <h1 class="text-center">Add a PhoneNumber:</h1>
    <?php
    \Framework\FormViewHelper::init()
        ->initForm('/PhoneNumber/add', ['class' => 'form-group'], 'post')
        ->initLabel()->setValue("Name")->setAttribute('for', 'name')->create()
        ->initTextBox()->setName('name')->setAttribute('id', 'name')->setAttribute('class', 'form-control input-md')->create()
        ->initLabel()->setValue("Number")->setAttribute('for', 'number')->create()
        ->initTextBox()->setName('number')->setAttribute('id', 'number')->setAttribute('class', 'form-control input-md')->create()
        ->initDiv()->setAttribute('class','margin-top row')->create()
        ->initSubmit()->setAttribute('value', 'Add')->setAttribute('class', 'btn btn-primary btn-lg col-sm-4 col-sm-offset-4')->create()
        ->render(); ?>
</div>