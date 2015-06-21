<?php

namespace Kh\MailBundle;

use Kh\CommentsBundle\CommentsSubscriptionManager;
use Kh\CommentsBundle\Entity\Comment;
use Kh\CommentsBundle\Entity\Subscription;
use Kh\UserBundle\Entity\User;
use Kh\UserBundle\UserManager;

class MailManager extends \Sv\MailBundle\MailManager
{

	public function commentMail(Comment $comment)
	{
		$this->adminMail('Новый комментарий', 'adminComment', [
			'comment' => $comment,
		]);
		/** @var Subscription $s */
		foreach ($this->getCommentsSubscriptionManager()->getSubscribes($comment->getPost()) as $s) {
			if (strtolower($s->getEmail()) != strtolower($comment->getEmail())) {
				$this->mail($s->getEmail(), 'Новый комментарий', 'comment', [
					'title' => $comment->getPost()->getTitle(),
					'author' => $comment->getUser() ? $comment->getUser()->getName() : $comment->getAuthor(),
					'text' => $comment->getText(),
					'commentUrl' => $this->c->getRouting()->getUrl('_post', ['id' => $comment->getPost()->getId()], true) . '#comment-' . $comment->getId(),
					'blogAuthor' => $this->c->getSettingsManager()->get('blogAuthor'),
					'unsubscribeLink' => $this->c->getRouting()->getUrl('_comments_unsubscribe', array('hash' => $s->getHash()), true),
				]);
			}
		}
	}

	public function restoreMail(User $user)
	{
		$this->userMail($user, 'Восстановление пароля', 'restore', [
			'restoreUrl' => $this->c->getRouting()->getUrl('_restore_final', ['hash' => $user->getRestoreHash()], true),
		]);
	}

	public function registerMail(User $user)
	{
		$this->userMail($user, 'Регистрация', 'register', [
			'confirmationUrl' => $this->c->getRouting()->getUrl('_confirm', ['hash' => $user->getConfirmationHash()], true),
		], false);
	}

	public function adminMail($subject, $template, $parameters)
	{
		$admins = array_merge($this->getUserManager()->getAdmins(), $this->getUserManager()->getEditors());
		foreach ($admins as $a) {
			$params = array_merge([
				'adminname' => $a->getName(),
			], $parameters);
			$this->mail($a->getEmail(), $subject, $template, $params);
		}
	}

	public function userMail(User $user, $subject, $template, $parameters)
	{
		$parameters = array_merge($parameters, [
			'username' => $user->getName(),
		]);

		$this->mail($user->getEmail(), $subject, $template, $parameters);
	}

	public function mail($to, $subject, $template, $parameters, $isHtml = true)
	{
		$from = 'no-reply@' . $this->c->getConfig()->getParameter('siteurl');
		$fromName = $this->c->getSettingsManager()->get('sitename');

		$parameters = array_merge($parameters, array(
			'subject' => $subject,
			'to' => $to,
			'sitename' => $this->c->getSettingsManager()->get('sitename'),
			'siteurl' => $this->c->getConfig()->getParameter('siteurl'),
		));

		$message = \Swift_Message::newInstance();
		$message->setSubject($subject);
		$message->setFrom($from, $fromName);
		$message->setReplyTo($from, $fromName);
		$message->setReturnPath($from);
		$message->setTo($to);
		$message->setBody($this->c->getApp()->getTwig()->render('Kh/MailBundle/Views/' . $template . '.twig', $parameters),
			$isHtml ? 'text/html' : 'text/plain');
		$this->swiftMail($message);
	}

	/**
	 * @return UserManager
	 */
	protected function getUserManager()
	{
		return $this->c->getApp()->get('manager.user');
	}

	/**
	 * @return CommentsSubscriptionManager
	 */
	protected function getCommentsSubscriptionManager()
	{
		return $this->c->getApp()->get('manager.comments_subscription');
	}

} 