<?php

namespace ContentBundle\Controller;

use BaseBundle\Controller\Controller;
use ContentBundle\BundleTrait;

class RssController extends Controller
{
    use BundleTrait;

	public function indexAction()
	{
		return $this->render('index', $this->getTemplateParameters([
			'webmaster' => $this->getSettingsService()->get('webmaster'),
			'posts' => $this->getPostService()->getPosts(null, null, 0, 10),
		]));
	}

	public function feedAction()
	{
		return $this->redirect('_rss');
	}

}