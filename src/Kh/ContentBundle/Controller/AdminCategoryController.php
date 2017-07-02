<?php

namespace Kh\ContentBundle\Controller;

use Kh\AdminBundle\Controller\CrudController;
use Kh\ContentBundle\Entity\Category;
use Kh\ContentBundle\Manager\CategoryManager;
use Svi\Base\Forms\Form;
use Svi\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminCategoryController extends CrudController
{

	protected function getListColumns()
	{
		return [
			'id' => '#',
			'name' => 'Название',
			'postsCount' => 'Кол-во постов',
		];
	}

	function deleteAction($id)
	{
		$request = $this->getRequest();

		if (!($category = $this->c->getCategoryManager()->getCategory($id))) {
			throw new NotFoundHttpException;
		}

		$form = $this->createForm()
			->add('moveToCategory', 'choice', [
				'label' => 'Переместить в категорию',
				'choices' => $this->c->getCategoryManager()->getCategoriesForSelect(),
			])
			->add('submit', 'submit', [
				'label' => 'Удалить',
				'cancel' => $this->getBackLink(),
			]);

		if ($form->handleRequest($request)->isValid()) {
			$data = $form->getData();
			if ($data['moveToCategory']) {
				$moveTo = $this->c->getCategoryManager()->getCategory($data['moveToCategory']);
			} else {
				$moveTo = null;
			}
			$this->c->getCategoryManager()->deleteCategory($category, $moveTo);

			$this->c->getAlertsService()->addAlert('success', 'Категория удалена');

			return $this->crudRedirect();
		}

		return $this->render('delete', $this->getTemplateParameters([
			'entity' => $category,
			'form' => $form,
		]));
	}

	/**
	 * @param Form $form
	 * @param Category $entity
	 */
	protected function buildForm(Form $form, Entity $entity)
	{
		$form
			->add('name', 'text', [
				'label' => 'Название',
				'required' => true,
				'data' => $entity->getName(),
			]);
	}

	protected function getRoutes()
	{
		return [
			'add' => '_admin_category_add',
			'edit' => '_admin_category_edit',
			'delete' => '_admin_category_delete',
		];
	}

	/**
	 * @return CategoryManager
	 */
	protected function getManager()
	{
		return CategoryManager::getInstance();
	}

}