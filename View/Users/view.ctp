<h1>ユーザー名:<?php echo $user['User']['username']; ?></h1>
<h1>メールアドレス:<?php echo h($user['User']['email']); ?></h1>
<h4>ユーザー画像</h4>
<?php
if ($user['User']['image_name']) {
	echo $this->Html->image($user['User']['image_name'], array('width'=>'200', 'height'=>'200'));
} else {
	echo '未登録';
}
?>
<p>一言コメント</p>
<p><?php echo h($user['User']['comment']); ?></p>
<?php
if ($auth['id'] == $user['User']['id']) {
	echo $this->Html->link(
	'一言コメント編集へ',
	array('action' => 'edit', $user['User']['id'])
	);
	echo '<br>';
	echo $this->Html->link(
	'プロフィール画像編集へ',
	array('action' => 'fileup', $user['User']['id'])
	);
}
echo '<br>';
echo $this->Html->link(
'ホーム', array('controller' => 'posts', 'action' => 'index')
);
?>

