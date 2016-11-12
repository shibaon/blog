<?php

namespace Kh\PromoBundle\Controller;

use Kh\BaseBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{

	public function pageAction($page)
	{
		if ($post = $this->c->getPostService()->getPostByAlias($page)) {
			return $this->redirect('_post', ['id' => $post->getId()]);
		}
		if (!$page) {
			$page = $this->c->getPageManager()->getPageByUrl(null);
		} else {
			$page = $this->c->getPageManager()->getPageByUrl($page);
		}
		if (!$page) {
			throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
		}
		if (!$page->getPublished() && (!$this->c->getUserService()->getCurrentUser() || !$this->c->getUserService()->getCurrentUser()->isAdmin())) {
			throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
		}

		return $this->render('page', $this->getTemplateParameters([
			'id' => $page->getId(),
			'title' => $page->getTitle(),
			'text' => $page->getText(),
			'published' => $page->getPublished(),
			'isAdmin' => $this->c->getUserService()->getCurrentAdmin() ? true : false,
		]));
	}

	public function notFoundAction()
	{
		return $this->render('404', $this->getTemplateParameters());
	}

}