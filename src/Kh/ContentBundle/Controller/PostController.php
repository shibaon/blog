<?php

namespace Kh\ContentBundle\Controller;

use Kh\BaseBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{

	public function indexAction($id, Request $request)
	{
		$user = $this->c->getUserService()->getCurrentUser();
		if (!($post = $this->c->getPostService()->getPost($id))) {
			throw new NotFoundHttpException;
		}
		if ((!$post->getPublished() && !$user->isAdmin()) || $post->getRemoved()) {
			throw new NotFoundHttpException;
		}

		$commentForm = $this->createForm();
		if (!$user) {
			$commentForm
				->add('author', 'text', array(
					'label' => 'Имя',
					'required' => true,
					'data' => $this->c->getCookies()->get('c_author'),
				))
				->add('email', 'email', array(
					'label' => 'Email (не обязательно)',
					'data' => $this->c->getCookies()->get('c_email'),
				))
				->add('url', 'text', array(
					'label' => 'Web-страница',
					'data' => $this->c->getCookies()->get('c_url'),
				))
				->add('address1', 'hidden', array(
					'data' => substr(md5(time() . microtime() . rand()), 0, 16),
				))
				->add('address2', 'hidden', array(
					'data' => substr(md5(time()), 0, 16),
				));
		}
		$commentForm
			->add('text', 'textarea', array(
				'label' => 'Текст комментария',
				'required' => true,
			));
		if (!$user || !$user->isAdmin()) {
			$commentForm
				->add('subscribe', 'checkbox', array(
					'label' => 'Подписаться на уведомления о новых комментариях',
					'required' => false,
					'data' => true,
				));
		}
		$commentForm
			->add('submit', 'submit', [
				'label' => 'Оставить комментарий (Ctrl + Enter)',
			]);

		if ($comment = $this->c->getCommentsService()->processCommentForm($commentForm, $post)) {
			$this->c->getAlertsService()->addAlert('success', 'Комментарий успешно добавлен');

			return $this->redirectToUrl($request->getRequestUri() . '#comment-' . $comment->getId());
		}

		return $this->render('index', $this->getTemplateParameters([
			'post' => $this->c->getPostService()->getPostForTemplate($post),
			'form' => $commentForm,
		]));
	}

}