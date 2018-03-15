<?php

namespace MailBundle\Service;

use BaseBundle\Service\SettingsService;
use CommentsBundle\Service\CommentsSubscriptionService;
use CommentsBundle\Entity\Comment;
use CommentsBundle\Entity\Subscription;
use ContentBundle\Service\PostService;
use Svi\HttpBundle\Service\RoutingService;
use Svi\TengineBundle\BundleTrait;
use UserBundle\Entity\User;
use UserBundle\Service\UserService;

class MailService extends \Svi\MailBundle\Service\MailService
{
    use BundleTrait;

	public function commentMail(Comment $comment)
	{
		$post = $this->getPostService()->getPost($comment->getPostId());
		$user = $this->getUserService()->getUserById($comment->getId());

		$this->adminMail('Новый комментарий', 'adminComment', [
			'comment' => $comment,
			'commentUrl' => $this->getRoutingService()->getUrl('_post', ['id' => $post->getId()], true) . '#comment-' . $comment->getId(),
		]);
		/** @var Subscription $s */
		foreach ($this->getCommentsSubscriptionService()->getSubscribes($post) as $s) {
			if (strtolower($s->getEmail()) != strtolower($comment->getEmail())) {
				$this->mail($s->getEmail(), 'Новый комментарий', 'comment', [
					'title' => $post->getTitle(),
					'author' => $user ?: $comment->getAuthor(),
					'text' => $comment->getText(),
					'commentUrl' => $this->getRoutingService()->getUrl('_post', ['id' => $post->getId()], true) . '#comment-' . $comment->getId(),
					'blogAuthor' => $this->getSettingsService()->get('blogAuthor'),
					'unsubscribeLink' => $this->getRoutingService()->getUrl('_comments_unsubscribe', array('hash' => $s->getHash()), true),
				]);
			}
		}
	}

	public function restoreMail(User $user)
	{
		$this->userMail($user, 'Восстановление пароля', 'restore', [
			'restoreUrl' => $this->getRoutingService()->getUrl('_restore_final', ['hash' => $user->getRestoreHash()], true),
		]);
	}

	public function registerMail(User $user)
	{
		$this->userMail($user, 'Регистрация', 'register', [
			'confirmationUrl' => $this->getRoutingService()->getUrl('_confirm', ['hash' => $user->getConfirmationHash()], true),
		]);
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
		$from = 'no-reply@' . $this->app->getConfigService()->getParameter('siteurl');
		$fromName = $this->getSettingsService()->get('sitename');

		$parameters = array_merge($parameters, array(
			'subject' => $subject,
			'to' => $to,
			'sitename' => $this->getSettingsService()->get('sitename'),
			'siteurl' => $this->app->getConfigService()->getParameter('siteurl'),
		));

		$message = new \Swift_Message();
		$message->setSubject($subject);
		$message->setFrom($from, $fromName);
		$message->setReplyTo($from, $fromName);
		$message->setReturnPath($from);
		$message->setTo($to);
		$message->setBody($this->getTemplateService()->render('MailBundle/Views/' . $template, $parameters),
			$isHtml ? 'text/html' : 'text/plain');
		$this->swiftMail($message);
	}

	/**
	 * @return UserService
	 */
	protected function getUserService()
	{
		return $this->app[UserService::class];
	}

	/**
	 * @return CommentsSubscriptionService
	 */
	protected function getCommentsSubscriptionService()
	{
		return $this->app[CommentsSubscriptionService::class];
	}

	/**
	 * @return PostService
	 */
	protected function getPostService()
	{
		return $this->app[PostService::class];
	}

	protected function getRoutingService()
    {
        return $this->app[RoutingService::class];
    }

    /**
     * @return SettingsService
     */
    protected function getSettingsService()
    {
        return $this->app[SettingsService::class];
    }

} 