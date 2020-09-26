<h1>File Upload</h1>
<?php
echo $this->Form->create('User', array('type' => 'file', 'enctype' => 'multipart/form-data'));
echo $this->Form->input('image_name', array('label' => false, 'type' => 'file', 'multiple'));
echo $this->Form->submit('upload', array('name' => 'submit'));
echo $this->Form->end();
?>
