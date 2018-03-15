<?php

namespace CommentsBundle\Service;

use CommentsBundle\BundleTrait;
use CommentsBundle\Entity\Comment;
use CommentsBundle\Manager\CommentManager;
use ContentBundle\Entity\Post;
use Svi\AppContainer;
use Svi\HttpBundle\Forms\Form;

class CommentsService extends AppContainer
{
    use BundleTrait;
    use \Svi\HttpBundle\BundleTrait;
    use \UserBundle\BundleTrait;
    use \MailBundle\BundleTrait;
    use \ContentBundle\BundleTrait;

	public function processCommentForm(Form $form, Post $post)
	{
		$request = $this->getRequest();
		if ($form->handleRequest($this->getRequest())->isValid()) {
			$data = $form->getData();
			if (!($user = $this->getUserService()->getCurrentUser()) && (!isset($data['address1']) || !isset($data['address2']) || $data['address1'] != $data['address2'])) {
				$this->getAlertsService()->addAlert('error', 'Ошибка публикации комментария. Возможно, вы бот.');

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
				$this->getCookiesService()->set('c_author', $data['author']);
			}
			if (@$data['email']) {
				$this->getCookiesService()->set('c_email', $data['email']);
			}
			if (@$data['url']) {
				$this->getCookiesService()->set('c_url', $data['url']);
			}

			if (@$data['email'] && @$data['subscribe']) {
				$this->getCommentsSubscriptionService()->subscribe($post, $data['email']);
			}

			$this->getMailService()->commentMail($comment);

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
		$user = $this->getUserService()->getUserById($comment->getId());

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
		$post = $this->getPostManager()->findOneById($comment->getPostId());

		return [
			'id' => $comment->getId(),
			'author' => $author,
			'url' => $url,
			'email' => $email,
			'date' => date('d.m.Y в H:i', $comment->getTimestamp()),
			'text' => $comment->getText(),
			'avatar' => $avatar,
			'post' => [
				'title' => $post->getTitle(),
				'href' => $this->getRoutingService()->getUrl('_post', ['id' => $post->getId()]),
            ],
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
		$this->getPostManager()->save($post->setCommentsCount($this->getCommentsCount($post)));
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
		return $this->getCommentManager();
	}

}