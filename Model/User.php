<?php
App::uses('AppModel', 'Model');
APP::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
	public $validate = array(
		'comment' => array(
			'rule' => 'notBlank',
			'message' => 'コメントを入力してください'
		),
		'username' => array(
			'rule' => 'notBlank',
			'message' => 'ユーザーネームを入力してください'
		),
		'email' => array(
			array(
			'rule' => 'notBlank',
			'message' => 'メールアドレスを入力してください'
			),
			array(
			'rule' => 'email',
			'message' => '正しいメールアドレスを入力してください'
			),
			array(
			'rule' => 'isUnique',
			'message' => '入力されたメールアドレスは既に登録されています'),
		),
		'password' => array(
			array(
			'rule' => 'notBlank',
			'message' => 'パスワードを入力してください'
			),
			array(
			'rule' => 'alphanumericsymbols',
			'message' => 'パスワードに使用できない文字が入力されています'),
		),
		'password_confirm' => array(
			array(
			'rule' => 'notEmpty',
			'message' => 'パスワード(確認)を入力してください'
			)
		),
		'image_name' => array(
			'rule1' => array(
				'rule' => array('extension', array('jpg', 'jpeg', 'gif', 'png')),
				'message' => '画像ではありません',
				'allowEmpty' => true,
			),
			'rule2' => array(
				'rule' => array('filesize', '<=', '5000000'),
				'message' => '画像サイズは5MB以下でお願いします',
			),
		),
	);


	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
			$this->data[$this->alias]['password']);
		}
		return true;
	}
	public function passwordConfirm($check) {
		if ($this->data['User']['password'] === $this->data['User']['password_confirm']) {
			return true;
		} else {
			return false;
		}
	}
	public function alphanumericsymbols($check) {
		$value = array_values($check);
		$value = $value[0];
		return preg_match('/^[a-zA-Z0-9\s\x21-\x2f\x3a-\x40\x5b-\x60\x7b-\x7e]+$/', $value);
	}
}
