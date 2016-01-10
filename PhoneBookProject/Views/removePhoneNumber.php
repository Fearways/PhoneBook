<div class="panel panel-primary  col-sm-6 col-sm-offset-3">
    <h1 class="text-center">Are you sure you want to remove this PhoneNumber?</h1>
    <?php
    \Framework\FormViewHelper::init()
        ->initForm('/PhoneNumber/deletePhoneNumber', ['class' => 'form-group'], 'post')
        ->initSubmit()->setAttribute('value', 'Remove Phone Number')->setAttribute('class', 'btn btn-primary btn-lg col-md-6 col-md-offset-3')->create()
        ->render(); ?>
</div>