<?php

namespace ContentBundle\Controller;

use BaseBundle\Controller\Controller;
use ContentBundle\BundleTrait;
use Svi\HttpBundle\Utils\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Svi\HttpBundle\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    use BundleTrait;

	public function indexAction($id, Request $request)
	{
		if (!($category = $this->getCategoryService()->getCategory($id))) {
			throw new NotFoundHttpException;
		}

		$paginator = new Paginator($this->getPostService()->getPostsCount($category), 10, $request);
		$posts = $this->getPostService()->getPosts($category, null, $paginator->getCurrentPage(), $paginator->getItemsPerPage());

		$category->setPostsCount($paginator->getTotalItems());
		$this->getCategoryManager()->save($category);

		return $this->render('index', $this->getTemplateParameters([
			'posts' => array(
				'items' => $posts,
				'pages' => $paginator->getView(),
			),
			'count' => $paginator->getTotalItems(),
			'category' => $category,
		]));
	}

}