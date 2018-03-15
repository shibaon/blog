<?php

namespace CommentsBundle\Controller;

use BaseBundle\Controller\Controller;
use CommentsBundle\BundleTrait;
use CommentsBundle\Entity\Comment;
use Svi\HttpBundle\Utils\Paginator;
use Symfony\Component\HttpFoundation\Request;

class CommentsController extends Controller
{
    use BundleTrait;
    use \ContentBundle\BundleTrait;

	public function indexAction(Request $request)
	{
		$manager = $this->getCommentManager();
		$service = $this->getCommentsService();

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

		if (!($comment = $this->getCommentsService()->getComment($data['cid']))) {
			return $this->jsonError();
		}

		$this->getCommentManager()->delete($comment);
		$this->getCommentsService()->updatePostCommentsCount(
			$this->getPostService()->getPost($comment->getPostId())
		);

		return $this->jsonSuccess();
	}

}