<?php

namespace AdminBundle\Controller;

class FrontController extends Controller
{

	public function indexAction()
	{
		return $this->render('index', $this->getTemplateParameters([

		]));
	}

} 