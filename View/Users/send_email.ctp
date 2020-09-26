<div class ="Mail form">
<?php echo $this->Form->create('User'); ?>
<fieldset>
<legend><?php echo 'Plese Send your registered email address'; ?></legend>
<?php echo $this->Form->input('email'); ?>
</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
