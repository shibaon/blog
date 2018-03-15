<?php

namespace PromoBundle\Controller;

use BaseBundle\Controller\Controller;
use PromoBundle\BundleTrait;
use Svi\HttpBundle\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    use BundleTrait;
    use \ContentBundle\BundleTrait;

	public function pageAction($page)
	{
		if ($post = $this->getPostService()->getPostByAlias($page)) {
			return $this->redirect('_post', ['id' => $post->getId()]);
		}
		if (!$page) {
			$page = $this->getPageService()->getPageByUrl(null);
		} else {
			$page = $this->getPageService()->getPageByUrl($page);
		}
		if (!$page) {
			throw new NotFoundHttpException();
		}
		if (!$page->getPublished() && (!$this->getCurrentUser() || !$this->getCurrentUser()->isAdmin())) {
			throw new NotFoundHttpException();
		}

		return $this->render('page', $this->getTemplateParameters([
			'id' => $page->getId(),
			'title' => $page->getTitle(),
			'text' => $page->getText(),
			'published' => $page->getPublished(),
			'isAdmin' => $this->getCurrentAdmin() ? true : false,
		]));
	}

	public function notFoundAction()
	{
		return $this->render('404', $this->getTemplateParameters());
	}

}