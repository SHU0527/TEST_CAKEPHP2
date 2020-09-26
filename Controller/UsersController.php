<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

Class UsersController extends AppController {
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('add', 'logout', 'send_email','pass_reset');
	}
	public function view($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid user'));
		}
		$user = $this->User->findById($id);
		if (!$user) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $user);
	}
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved'));
				return $this->redirect(array('action' => 'login'));
			}
			$this->Flash->error(
			__('The user could not be saved.please, try again.'));
		}
	}
	public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid post'));
		}
		$user = $this->User->findById($id);
		if (!$user) {
			throw new NotFoundException(__('Invalid post'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->User->id = $id;
			if ($user['User']['id'] == $this->Auth->user('id')) {
				if ($this->User->save($this->request->data)) {
					$this->Flash->success(__('Your post has been updated.'));
					return $this->redirect(array('action' => 'view', $user['User']['id']));
				}
				$this->Flash->error(__('Unable to update your post.'));
			} else {
				$this->Flash->error(__('Unable to update your post.'));
				return $this->redirect(array('action' => 'view', $user['User']['id']));
			}
		}
		if (!$this->request->data) {
			$this->request->data = $user;
		}
	}
	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirectUrl());
			} else {
				$this->Flash->error(__('Invalid email or password is incorrerct'));
			}
		}
	}
	public function logout() {
		$this->redirect($this->Auth->logout());
	}
	public function isAuthorized($auth) {
		if (isset($auth)) {
			return true;
		}
	}
	public function fileup($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid post'));
		}
		$user = $this->User->findById($id);
		if (!$user) {
			throw new NotFoundException(__('Invalid post'));
		}
		if ($user['User']['id'] == $this->Auth->user('id')) {
			if ($this->request->is('post') || $this->request->is('put')) {
				$this->User->id = $id;
				$img = uniqid(mt_rand(), true);
				$img .= substr(strrchr($this->request->data['User']['image_name']['tmp_name'], '.'), 1);
				$image_name = $this->request->data['User']['image_name']['name'];
				$this->User->set($this->request->data);
				if ($image_name) {
					if ($this->User->validates()) {
						move_uploaded_file($this->request->data['User']['image_name']['tmp_name'], '../webroot/img/' . $img);
						if ($this->User->saveField('image_name', $img)) {
							$this->Flash->success(__('Your file has been upeloaded.'));
							return $this->redirect(array('action' => 'view', $user['User']['id']));
						}
					}
					$this->Flash->error(__('This is not an image.'));
					$this->redirect(array('action' => 'view', $user['User']['id']));
				} else {
					$this->Flash->error(__('Unable to update your file.'));
					return $this->redirect(array('action' => 'view', $user['User']['id']));
				}
			}
			if (!$this->request->data) {
				$this->request->data = $user;
			}
		} else {
			$this->Flash->error(__('This page is ohters page.'));
			return $this->redirect(array('action' => 'view', $user['User']['id']));
		}
	}
	public function send_email($id = null) {
		if ($this->request->is('post') || $this->request->is('put')) {
			$post_mail = $this->request->data['User']['email'];
			$matched_address = $this->User->find('first', array(
			'fields' => array('id'),
			'conditions' => array('email' => $post_mail)));
			if ($matched_address) {
				date_default_timezone_set("Asia/Tokyo");
				$mail_sent_date = date("Y/m/d h:i:s");
				$this->User->id = $matched_address['User']['id'];
				$token = uniqid(mt_rand(), true);
				$save_data = array('User' => array('mail_sent_date' => $mail_sent_date, 'token' => $token));
				$this->User->save($save_data);
				$url = "https://procir-study.site/maegawa207/cakephp/users/pass_reset?pass_reset_token=$token";
				$content = array('url' => $url);
				$email = new CakeEmail();
				$email->from('test@test.com');
				$email->to($post_mail);
				$email->template('text_email');
				$email->viewVars($content);
				$email->subject('パスワード再設定');
				$email->send();
			}
			$this->Flash->success(__('Your Mail has been sent.'));
			return $this->redirect(array('controller' => 'posts', 'action' => 'index'));
		}
	}
	public function pass_reset($id = null) {
		date_default_timezone_set("Asia/Tokyo");
		$limit_time = date("Y/m/d h:i:s", strtotime("-30 minute"));
		$key = $this->request->query['pass_reset_token'];
		$find_result = $this->User->find('first', array(
		'conditions' => array('token' => $key)));
		if ($this->request->is('post') || $this->request->is('put')) {
			if (strtotime($find_result['User']['mail_sent_date']) >= strtotime($limit_time)) {
				$pass = $this->request->data['User']['password'];
				$this->User->id = $find_result['User']['id'];
				$save_data = array('User' => array('password' => $pass, 'token' => null));
				$this->User->save($save_data);
				$this->Flash->success(__('Your Password is updated.'));
				return $this->redirect(array('action' => 'login'));
			} else {
				$this->Flash->error(__('This URL is invalid.'));
				return $this->redirect(array('action' => 'login'));
			}
		}
	}
}
