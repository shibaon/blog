<?php

namespace Kh\PromoBundle\Controller;

use Kh\AdminBundle\Controller\CrudController;
use Sv\BaseBundle\Forms\Form;

class AdminMenuController extends CrudController
{

	protected function buildForm(Form $form, $entity)
	{
		$form
			->add('title', 'text', array(
				'label' => 'crud.menu.title',
				'data' => $entity->getTitle(),
			))
			->add('url', 'text', array(
				'label' => 'crud.menu.url',
				'data' => $entity->getUrl(),
			));
	}

	protected function getListColumns()
	{
		return array(
			'title' => 'Заголовок',
			'url' => 'URL',
		);
	}

	public function getRoutes()
	{
		return array(
			'add' => '_admin_menu_add',
			'edit' => '_admin_menu_edit',
			'delete' => '_admin_menu_delete',
		);
	}

	protected function isSortable()
	{
		return true;
	}

	protected function getClassName()
	{
		return 'Kh\\PromoBundle\\Entity\\Menu';
	}

} 