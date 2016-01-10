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
    <h1 class="text-center">Edit a phone number</h1>
    <?php
    \Framework\FormViewHelper::init()
        ->initForm('/PhoneNumber/edit', ['class' => 'form-group'], 'post')
        ->initLabel()->setValue("name")->setAttribute('for', 'name')->create()
        ->initTextBox()->setAttribute('placeholder',$_SESSION['PnoneName'])->setName('name')->setAttribute('id', 'name')->setAttribute('class', 'form-control input-md')->create()
        ->initLabel()->setValue("number")->setAttribute('for', 'number')->create()
        ->initTextBox()->setAttribute('placeholder',$_SESSION['PnoneNumber'])->setName('number')->setAttribute('id', 'number')->setAttribute('class', 'form-control input-md')->create()
        ->initDiv()->setAttribute('class','margin-top row')->create()
        ->initSubmit()->setAttribute('value', 'Edit')->setAttribute('class', 'btn btn-primary btn-lg col-sm-4 col-sm-offset-4')->create()
        ->render(); ?>
</div>