<?php

namespace Kh\PromoBundle\Controller;

use Kh\AdminBundle\Controller\CrudController;
use Kh\PromoBundle\Entity\Page;
use Kh\PromoBundle\Manager\PageManager;
use Svi\Base\Forms\Form;
use Svi\Entity;

class AdminPageController extends CrudController
{

	/**
	 * @param Form $builder
	 * @param Page $entity
	 */
	protected function buildForm(Form $builder, Entity $entity)
	{
		if ($entity instanceof Page) {
			$builder
				->add('title', 'text', array(
					'label' => 'crud.page.title',
					'required' => true,
					'data' => $entity->getTitle(),
				))
				->add('text', 'textarea', array(
					'label' => 'crud.page.text',
					'required' => false,
					'data' => $entity->getText(),
					'attr' => array(
						'data-wysiwyg' => true,
					),
				))
				->add('uri', 'text', array(
					'label' => 'crud.page.url',
					'required' => false,
					'data' => $entity->getUri(),
				))
				->add('published', 'checkbox', array(
					'label' => 'crud.page.published',
					'required' => false,
					'data' => $entity->getPublished(),
				));
		}
	}

	public function getRoutes()
	{
		return array(
			'add' => '_admin_pages_add',
			'edit' => '_admin_pages_edit',
			'delete' => '_admin_pages_delete',
		);
	}

	protected function getListColumns()
	{
		return array(
			'id' => 'id',
			'title' => 'Заголовок',
			'uri' => 'URI',
			'published' => 'Опубликовано',
		);
	}

	protected function getManager()
	{
		return $this->c->getPromoBundle()->getPageManager();
	}

} 