<?php

namespace Kh\ContentBundle\Controller;

use Kh\BaseBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RssController extends Controller
{

	public function indexAction()
	{
		return $this->getTemplateParameters(array(
			'webmaster' => $this->c->getSettingsManager()->get('webmaster'),
			'posts' => $this->c->getPostManager()->getPosts(null, null, 0, 10),
		));
	}

	public function feedAction()
	{
		return $this->redirect('_rss');
	}

}