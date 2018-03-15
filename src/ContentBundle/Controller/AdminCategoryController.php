<?php

namespace ContentBundle\Controller;

use AdminBundle\Controller\CrudController;
use ContentBundle\BundleTrait;
use ContentBundle\Entity\Category;
use ContentBundle\Manager\CategoryManager;
use Svi\HttpBundle\Forms\Form;
use Svi\OrmBundle\Entity;
use Svi\HttpBundle\Exception\NotFoundHttpException;

class AdminCategoryController extends CrudController
{
    use BundleTrait;

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

		if (!($category = $this->getCategoryService()->getCategory($id))) {
			throw new NotFoundHttpException;
		}

		$form = $this->createForm()
			->add('moveToCategory', 'choice', [
				'label' => 'Переместить в категорию',
				'choices' => $this->getCategoryService()->getCategoriesForSelect(),
			])
			->add('submit', 'submit', [
				'label' => 'Удалить',
				'cancel' => $this->getBackLink(),
			]);

		if ($form->handleRequest($request)->isValid()) {
			$data = $form->getData();
			if ($data['moveToCategory']) {
				$moveTo = $this->getCategoryService()->getCategory($data['moveToCategory']);
			} else {
				$moveTo = null;
			}
			$this->getCategoryService()->deleteCategory($category, $moveTo);

			$this->getAlertsService()->addAlert('success', 'Категория удалена');

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
		return $this->getCategoryManager();
	}

}