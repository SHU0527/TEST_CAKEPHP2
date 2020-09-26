<h1>Blog posts</h1>
<?php if (isset($auth['id'])): ?>
	<?php echo $this->Html->link(
	'post',
	array('action' => 'add'));
	?>
	<br>
	<?php echo $this->Html->link(
	'logout',
	array('controller' => 'users', 'action' => 'logout'));
	?>
<?php else: ?>
	<?php echo $this->Html->link(
	'login',
	array('controller' => 'users', 'action' => 'login'));
	?>
	<br>
	<?php echo $this->Html->link(
	'register for membership',
	array('controller' => 'users', 'action' => 'add'));
	?>
<?php endif; ?>

<table>
<tr>
<th>Username</th>
<th>Title</th>
<th>Action</th>
<th>Created</th>
</tr>

<?php foreach ($posts as $post): ?>
	<tr>
	<td>
		<?php echo $this->Html->link(
	$post['User']['username'],
	array('controller' => 'users', 'action' => 'view', $post['Post']['user_id']));
	?>
	</td>
	<td>
	<?php echo $this->Html->link(
	$post['Post']['title'],
	array('action' => 'view', $post['Post']['id']));
	?>
	</td>
	<td>
	<?php if (isset($auth['id']) && $auth['id'] == $post['Post']['user_id'])
: ?>
	<?php echo $this->Form->postLink(
	'Delete',
	array('action' => 'delete', $post['Post']['id']),
	array('confirm' => 'Are you sure?'));
	?>
	<?php echo $this->Html->link(
	'Edit',
	array('action' => 'edit', $post['Post']['id']));
	?>
	<?php endif; ?>
	</td>
	<td><?php echo $post['Post']['created']; ?></td>
	</tr>
<?php endforeach; ?>
<?php unset($post); ?>
</table>


