<?php

namespace PromoBundle\Controller;

use AdminBundle\Controller\CrudController;
use PromoBundle\BundleTrait;
use PromoBundle\Entity\Menu;
use PromoBundle\Manager\MenuManager;
use Svi\HttpBundle\Forms\Form;
use Svi\OrmBundle\Entity;

class AdminMenuController extends CrudController
{
    use BundleTrait;

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
		return $this->getMenuManager();
	}

} 