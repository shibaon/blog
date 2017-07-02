<?php

namespace Kh\ContentBundle\Controller;

use Kh\BaseBundle\Controller\Controller;
use Kh\ContentBundle\Manager\CategoryManager;
use Svi\Base\Utils\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{

	public function indexAction($id, Request $request)
	{
		if (!($category = $this->c->getCategoryService()->getCategory($id))) {
			throw new NotFoundHttpException;
		}

		$paginator = new Paginator($this->c->getPostService()->getPostsCount($category), 10, $request);
		$posts = $this->c->getPostService()->getPosts($category, null, $paginator->getCurrentPage(), $paginator->getItemsPerPage());

		$category->setPostsCount($paginator->getTotalItems());
		CategoryManager::getInstance()->save($category);

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