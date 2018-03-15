<?php

namespace PromoBundle\Controller;

use BaseBundle\Controller\Controller;
use PromoBundle\BundleTrait;
use Svi\HttpBundle\Utils\Paginator;
use Symfony\Component\HttpFoundation\Request;

class FrontController extends Controller
{
    use BundleTrait;
    use \ContentBundle\BundleTrait;

	public function indexAction(Request $request)
	{
		$search = $request->query->has('search') ? $request->query->get('search') : null;

		$paginator = new Paginator($this->getPostService()->getPostsCount(null, $search), 10, $request);

		return $this->render('index', $this->getTemplateParameters([
			'posts' => array(
				'pages' => $paginator->getView(),
				'items' => $this->getPostService()
					->getPosts(null, $search, $paginator->getCurrentPage(), $paginator->getItemsPerPage()),
			),
			'count' => $paginator->getTotalItems(),
			'search' => $search,
		]));
	}

} 