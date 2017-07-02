<?php

namespace Kh\CommentsBundle\Controller;

use Kh\BaseBundle\Controller\Controller;
use Kh\CommentsBundle\Entity\Comment;
use Kh\CommentsBundle\Manager\CommentManager;
use Svi\Base\Utils\Paginator;
use Symfony\Component\HttpFoundation\Request;

class CommentsController extends Controller
{

	public function indexAction(Request $request)
	{
		$db = CommentManager::getInstance()->getConnection()->createQueryBuilder()->select('COUNT(*)')->from('comment', '');
		$paginator = new Paginator($db->execute()->fetchColumn(0), 30, $request, 14);
		$db
			->select('')
			->orderBy('timestamp', 'desc')
			->setFirstResult($paginator->getCurrentPage() * $paginator->getItemsPerPage())
			->setMaxResults($paginator->getItemsPerPage());

		$comments = [];
		/** @var Comment $c */
		foreach (CommentManager::getInstance()->fetch($db) as $c) {
			$comments[] = $this->c->getCommentsService()->getCommentForTemplate($c);
		}

		return $this->render('index', $this->getTemplateParameters([
			'pages' => $paginator->getView(),
			'comments' => $comments,
		]));
	}

	public function deleteAction(Request $request)
	{
		if (!($user = $this->c->getUserService()->getCurrentUser()) || !$user->isAdmin()) {
			return $this->jsonError();
		}
		$data = $request->request->all();

		if (!($comment = $this->c->getCommentsService()->getComment($data['cid']))) {
			return $this->jsonError();
		}

		CommentManager::getInstance()->delete($comment);
		$this->c->getCommentsService()->updatePostCommentsCount($comment->getPost());

		return $this->jsonSuccess();
	}

}