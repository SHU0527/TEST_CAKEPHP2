<div class ="New Password form">
<?php echo $this->Form->create('User'); ?>
<fieldset>
<legend><?php echo 'please enter a new password'; ?></legend>
<?php echo $this->Form->input('password'); ?>
</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
