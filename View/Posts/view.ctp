<h1><?php echo h($post['User']['username']); ?></h1>
<h1><?php echo h($post['Post']['title']); ?></h1>
 <p><small>Created: <?php echo $post['Post']['created']; ?></small></p>
<p><?php echo h($post['Post']['body']); ?></p>
