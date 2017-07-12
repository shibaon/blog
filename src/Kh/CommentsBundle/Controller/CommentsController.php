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
		$manager = $this->c->getCommentsBundle()->getCommentManager();
		$service = $this->c->getCommentsBundle()->getCommentsService();

		$db = $manager->getConnection()->createQueryBuilder()->select('COUNT(*)')->from('comment', '');
		$paginator = new Paginator($db->execute()->fetchColumn(0), 30, $request, 14);
		$db
			->select('')
			->orderBy('timestamp', 'desc')
			->setFirstResult($paginator->getCurrentPage() * $paginator->getItemsPerPage())
			->setMaxResults($paginator->getItemsPerPage());

		$comments = [];
		/** @var Comment $c */
		foreach ($manager->fetch($db) as $c) {
			$comments[] = $service->getCommentForTemplate($c);
		}

		return $this->render('index', $this->getTemplateParameters([
			'pages' => $paginator->getView(),
			'comments' => $comments,
		]));
	}

	public function deleteAction(Request $request)
	{
		if (!($user = $this->getCurrentUser()) || !$user->isAdmin()) {
			return $this->jsonError();
		}
		$data = $request->request->all();

		if (!($comment = $this->c->getCommentsBundle()->getCommentsService()->getComment($data['cid']))) {
			return $this->jsonError();
		}

		$this->c->getCommentsBundle()->getCommentManager()->delete($comment);
		$this->c->getCommentsBundle()->getCommentsService()->updatePostCommentsCount(
			$this->c->getContentBundle()->getPostService()->getPost($comment->getPostId())
		);

		return $this->jsonSuccess();
	}

}