<?php

namespace Kh\MailBundle\Service;

use Kh\CommentsBundle\Service\CommentsSubscriptionService;
use Kh\CommentsBundle\Entity\Comment;
use Kh\CommentsBundle\Entity\Subscription;
use Kh\ContentBundle\Service\PostService;
use Kh\UserBundle\Entity\User;
use Kh\UserBundle\Service\UserService;

class MailService extends \Svi\Mail\Service\MailService
{

	public function commentMail(Comment $comment)
	{
		$post = $this->getPostService()->getPost($comment->getPostId());
		$user = $this->getUserService()->getUserById($comment->getId());

		$this->adminMail('Новый комментарий', 'adminComment', [
			'comment' => $comment,
			'commentUrl' => $this->c->getRouting()->getUrl('_post', ['id' => $post->getId()], true) . '#comment-' . $comment->getId(),
		]);
		/** @var Subscription $s */
		foreach ($this->getCommentsSubscriptionService()->getSubscribes($post) as $s) {
			if (strtolower($s->getEmail()) != strtolower($comment->getEmail())) {
				$this->mail($s->getEmail(), 'Новый комментарий', 'comment', [
					'title' => $post->getTitle(),
					'author' => $user ?: $comment->getAuthor(),
					'text' => $comment->getText(),
					'commentUrl' => $this->c->getRouting()->getUrl('_post', ['id' => $post->getId()], true) . '#comment-' . $comment->getId(),
					'blogAuthor' => $this->c->getSettingsService()->get('blogAuthor'),
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
		$admins = array_merge($this->getUserService()->getAdmins(), $this->getUserService()->getEditors());
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
		$fromName = $this->c->getSviBaseBundle()->getSettingsService()->get('sitename');

		$parameters = array_merge($parameters, array(
			'subject' => $subject,
			'to' => $to,
			'sitename' => $this->c->getSviBaseBundle()->getSettingsService()->get('sitename'),
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
	 * @return UserService
	 */
	protected function getUserService()
	{
		return $this->c->getApp()->get('service.user');
	}

	/**
	 * @return CommentsSubscriptionService
	 */
	protected function getCommentsSubscriptionService()
	{
		return $this->c->getApp()->get('service.comments_subscription');
	}

	/**
	 * @return PostService
	 */
	protected function getPostService()
	{
		return $this->c->getApp()->get('service.post');
	}

} 