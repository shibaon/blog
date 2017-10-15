<?php

namespace Kh\CommentsBundle\Service;

use Kh\BaseBundle\ContainerAware;
use Kh\CommentsBundle\Entity\Comment;
use Kh\CommentsBundle\Manager\CommentManager;
use Kh\ContentBundle\Entity\Post;
use Kh\ContentBundle\Manager\PostManager;
use Svi\Base\Forms\Form;

class CommentsService extends ContainerAware
{

	public function processCommentForm(Form $form, Post $post)
	{
		$request = $this->getRequest();
		if ($form->handleRequest($this->getRequest())->isValid()) {
			$data = $form->getData();
			if (!($user = $this->c->getUserBundle()->getUserService()->getCurrentUser()) && (!isset($data['address1']) || !isset($data['address2']) || $data['address1'] != $data['address2'])) {
				$this->c->getAlertsService()->addAlert('error', 'Ошибка публикации комментария. Возможно, вы бот.');

				return null;
			}
			$comment = new Comment();
			$comment
				->setUserId($user ? $user->getId() : null)
				->setAuthor(@$data['author'])
				->setEmail(strtolower(@$data['email']))
				->setUrl(@$data['url'])
				->setText($data['text'])
				->setPostId($post->getId())
				->resetTimestamp()
				->setIp($request->getClientIp());
			$this->getManager()->save($comment);
			$this->updatePostCommentsCount($post);

			if (@$data['author']) {
				$this->c->getCookies()->set('c_author', $data['author']);
			}
			if (@$data['email']) {
				$this->c->getCookies()->set('c_email', $data['email']);
			}
			if (@$data['url']) {
				$this->c->getCookies()->set('c_url', $data['url']);
			}

			if (@$data['email'] && @$data['subscribe']) {
				$this->c->getCommentsBundle()->getCommentsSubscriptionService()->subscribe($post, $data['email']);
			}

			$this->c->getMailBundle()->getMailService()->commentMail($comment);

			return $comment;
		}

		return null;
	}

	public function getPostCommentsForTemplate(Post $post)
	{
		$result = array();
		/** @var Comment $c */
		foreach ($this->getManager()->findBy(['post_id' => $post->getId()], ['timestamp' => 'asc']) as $c) {
			$result[] = $this->getCommentForTemplate($c);
		}

		return $result;
	}

	public function getCommentForTemplate(Comment $comment)
	{
		$user = $this->c->getUserBundle()->getUserService()->getUserById($comment->getId());

		$author = $user ? $user->getName() : $comment->getAuthor();
		$email = $user ? $user->getEmail() : $comment->getEmail();

		$url = $comment->getUrl();
		if ($url) {
			if (strpos($url, 'http') === false) {
				$url = 'http://' . $url;
			}
		}
		$default = $this->getRequest()->getSchemeAndHttpHost() . '/bundles/khbase/img/default_avatar.png';
		if ($email) {
			$avatar = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode($default) . "&s=" . 80;
		} else {
			$avatar = $default;
		}

		/** @var Post $post */
		$post = $this->c->getContentBundle()->getPostManager()->findOneById($comment->getPostId());

		return [
			'id' => $comment->getId(),
			'author' => $author,
			'url' => $url,
			'email' => $email,
			'date' => date('d.m.Y в H:i', $comment->getTimestamp()),
			'text' => $comment->getText(),
			'avatar' => $avatar,
			'post' => array(
				'title' => $post->getTitle(),
				'href' => $this->c->getRouting()->getUrl('_post', ['id' => $post->getId()]),
			),
		];
	}

	/**
	 * @param $id
	 * @return Comment
	 */
	public function getComment($id)
	{
		return $this->getManager()->findOneById($id);
	}

	public function updatePostCommentsCount(Post $post)
	{
		$this->c->getContentBundle()->getPostManager()->save($post->setCommentsCount($this->getCommentsCount($post)));
	}

	public function getCommentsCount(Post $post)
	{
		return $this->getManager()->getConnection()->executeQuery('SELECT COUNT(*) FROM comment WHERE post_id = :post', ['post' => $post->getId()])->fetchColumn(0);
	}

	/**
	 * @return CommentManager
	 */
	public function getManager()
	{
		return $this->c->getCommentsBundle()->getCommentManager();
	}

}