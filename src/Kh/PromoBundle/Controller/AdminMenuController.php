<?php

namespace Kh\PromoBundle\Controller;

use Kh\AdminBundle\Controller\CrudController;
use Kh\PromoBundle\Entity\Menu;
use Kh\PromoBundle\Manager\MenuManager;
use Svi\Base\Forms\Form;
use Svi\Entity;

class AdminMenuController extends CrudController
{

	/**
	 * @param Form $form
	 * @param Menu $entity
	 */
	protected function buildForm(Form $form, Entity $entity)
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

	/**
	 * @return MenuManager
	 */
	protected function getManager()
	{
		return MenuManager::getInstance();
	}

} 