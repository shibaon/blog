<?php

namespace Kh\UserBundle\Controller;

use Kh\BaseBundle\Controller\Controller;
use Kh\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{

	public function profileEditAction(Request $request)
	{
		if (!($user = $this->c->getUserService()->getCurrentUser())) {
			throw new AccessDeniedHttpException();
		}
		$passwordChange = false;

		$form = $this->createForm()
			->add('email', 'email', [
				'label' => 'Email',
				'required' => true,
				'readOnly' => true,
				'disabled' => true,
				'data' => $user->getEmail(),
			])
			->add('name', 'text', [
				'label' => 'Ваше имя',
				'required' => false,
				'data' => $user->getName(),
			])
			->add('password', 'password', [
				'label' => 'Текущий пароль',
				'required' => false,
			])
			->add('newPassword', 'password', [
				'label' => 'Новый пароль',
				'required' => false,
			])
			->add('repeat', 'password', [
				'label' => 'Повторите пароль',
				'required' => false,
			])
			->add('submit', 'submit', [
				'label' => 'Изменить',
			])
			->setNoValidate(true);

		if ($form->handleRequest($request)->isValid()) {
			$data = $form->getData();
			if ($data['password'] || $data['newPassword'] || $data['repeat']) {
				$passwordChange = true;

				if (!$data['password']) {
					$form->get('password')->addError('Не указан текущий пароль');
				} elseif (!$this->c->getUserService()->checkPassword($user, $data['password'])) {
					$form->get('password')->addError('Неправильный пароль');
				}
				if (!$data['newPassword']) {
					$form->get('newPassword')->addError('Не указан новый пароль');
				} elseif ($data['newPassword'] != $data['repeat']) {
					$form->get('repeat')->addError('Пароли не совпадают');
				}
				if ($form->isValid()) {
					$user->setPassword($this->c->getUserService()->hashPassword($data['newPassword']));
				}
			}
			if ($form->isValid()) {
				$user
					->setName($data['name'])
					->save();

				$this->c->getAlertsService()->addAlert('success', 'Профиль успешно обновлён.');

				return $this->redirectToUrl($request->getRequestUri());
			}
		}

		return $this->render('profileEdit', $this->getTemplateParameters([
			'form' => $form,
			'passwordChange' => $passwordChange,
			'hideSidebar' => true,
		]));
	}

	public function restoreFinalAction($hash, Request $request)
	{
		if (!($user = $this->c->getUserService()->getUserByRestoreHash($hash))) {
			throw new NotFoundHttpException;
		}

		$form = $this->createForm()
			->add('password', 'password', [
				'label' => 'Новый пароль',
				'required' => true,
			])
			->add('repeat', 'password', [
				'label' => 'Повторите пароль',
				'required' => true,
			])
			->add('submit', 'submit', [
				'label' => 'Сохранить новый пароль',
			]);

		if ($form->handleRequest($request)->isValid()) {
			$data = $form->getData();
			if ($data['password'] != $data['repeat']) {
				$form->get('repeat')->addError('Пароли не совпадают');
			}
			if ($form->isValid()) {
				$user->setPassword($this->c->getUserService()->hashPassword($data['password']));
				$user->save();
				$this->c->getAlertsService()->addAlert('success', 'Пароль успешно изменён');

				return $this->redirect('_login');
			}
		}

		return $this->render('restoreFinal', $this->getTemplateParameters([
			'form' => $form,
			'hideSidebar' => true,
		]));
	}

	public function restoreAction(Request $request)
	{
		$form = $this->createForm()
			->add('email', 'email', [
				'label' => 'Укажите ваш email',
				'required' => true,
			])
			->add('submit', 'submit', [
				'label' => 'Продолжить',
			]);

		if ($form->handleRequest($request)->isValid()) {
			$data = $form->getData();
			if (!($user = $this->c->getUserService()->getUserByEmail($data['email']))) {
				$form->get('email')->addError('Пользователь с таким email не найден');
			}
			if ($form->isValid()) {
				$user->resetRestoreHash();
				$user->save();
				$this->c->getAlertsService()->addAlert('success', 'На указанный почтовый ящик отправлено письмо со ссылкой для восстановления пароля');
				$this->c->getMailManager()->restoreMail($user);

				return $this->redirect('_login');
			}
		}

		return $this->render('restore', $this->getTemplateParameters([
			'form' => $form,
			'hideSidebar' => true,
		]));
	}

	public function loginAction(Request $request)
	{
		if ($user = $this->c->getUserService()->getCurrentUser()) {
			return $this->redirect('_front');
		}

		$form = $this->createForm()
			->add('email', 'email', [
				'label' => 'Email',
				'required' => true,
			])
			->add('password', 'password', [
				'label' => 'Пароль',
				'required' => true,
			])
			->add('submit', 'submit', [
				'label' => 'Авторизоваться',
			]);

		if ($form->handleRequest($request)->isValid()) {
			$data = $form->getData();
			if (
				!($user = $this->c->getUserService()->getUserByEmail($data['email'])) ||
				!$this->c->getUserService()->checkPassword($user, $data['password'])
			) {
				$form->addError('Пользователь с таким логином и паролем не найден');
			}

			if ($form->isValid()) {
				$this->c->getUserService()->login($user);
				$this->c->getAlertsService()->addAlert('success', 'Вы успешно авторизовались на сайте');

				if ($request->query->has('back')) {
					return $this->redirectToUrl($request->query->get('back'));
				} else {
					return $this->redirect('_front');
				}
			}
		}

		return $this->render('login', $this->getTemplateParameters([
			'form' => $form,
			'hideSidebar' => true,
		]));
	}

	public function registerAction(Request $request)
	{
		if ($user = $this->c->getUserService()->getCurrentUser()) {
			return $this->redirect('_front');
		}

		$form = $this->createForm()
			->add('email', 'email', [
				'label' => 'Email',
				'required' => true,
			])
			->add('name', 'text', [
				'label' => 'Ваше имя',
				'required' => false,
			])
			->add('password', 'password', [
				'label' => 'Пароль',
				'required' => true,
			])
			->add('repeat', 'password', [
				'label' => 'Повторите пароль',
				'required' => true,
			])
			->add('submit', 'submit', [
				'label' => 'Зарегистрироваться',
			]);

		if ($form->handleRequest($request)->isValid()) {
			$data = $form->getData();
			if ($data['password'] != $data['repeat']) {
				$form->get('repeat')->addError('Пароль не совпадают');
			}
			if ($this->c->getUserService()->getUserByEmail($data['email'])) {
				$form->get('email')->addError('Пользователь с таким email уже зарегистрирован.');
			}

			if ($form->isValid()) {
				$user = new User();
				$user
					->setName($data['name'])
					->setEmail($data['email'])
					->setPassword($this->c->getUserService()->hashPassword($data['password']))
					->resetRegisterTimestamp()
					->resetConfirmationHash();

				$user->save();
				$this->c->getUserService()->login($user);
				$this->c->getAlertsService()->addAlert('success', 'Вы успешно зарегистрировались, вам на почту отправлена инструкция по активации.');
				$this->c->getMailService()->registerMail($user);

				if ($request->query->has('back')) {
					return $this->redirectToUrl($request->query->get('back'));
				} else {
					return $this->redirect('_front');
				}
			}
		}

		return $this->render('register', $this->getTemplateParameters([
			'form' => $form,
			'hideSidebar' => true,
		]));
	}

	public function logoutAction()
	{
		$this->c->getUserService()->logout();

		return $this->redirect('_front');
	}

	public function confirmAction($hash)
	{
		if (!($user = $this->c->getUserService()->getUserByConfirmationHash($hash))) {
			throw new NotFoundHttpException;
		}

		$user->setConfirmationHash(null);
		$user->save();

		$this->c->getAlertsService()->addAlert('success', 'Email успешно подтверждён');

		return $this->redirect('_front');
	}

}
