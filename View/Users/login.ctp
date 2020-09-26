<div class ="users form">
<?php echo $this->Flash->render('auth'); ?>
<?php echo $this->Form->create('User'); ?>
<fieldset>
	<legend>
	<?php echo __('Please enter your email and password'); ?>
	</legend>
	<?php echo $this->Form->input('email');
	echo $this->Form->input('password');
	?>
</fieldset>
<?php echo $this->Form->end(__('Login'));
echo '<br>';
echo $this->Html->link(
'パスワードを忘れた方へ',
array('action' => 'send_email')
);
?>
</div>
