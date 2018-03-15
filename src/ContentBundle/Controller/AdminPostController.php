<?php

namespace ContentBundle\Controller;

use AdminBundle\Controller\CrudController;
use ContentBundle\BundleTrait;
use ContentBundle\Entity\Category;
use ContentBundle\Entity\Post;
use Svi\HttpBundle\Forms\Form;
use Svi\OrmBundle\Entity;

class AdminPostController extends CrudController
{
    use BundleTrait;

	protected function getListColumns()
	{
		return [
			'id' => '#',
			'title' => [
				'title' => 'Заголовок',
				'value' => function(Post $post){
					return [
						'type' => 'link',
						'href' => $this->getRoutingService()->getUrl('_post', ['id' => $post->getId()]),
						'value' => $post->getTitle(),
					];
				}
			],
			'timestamp' => [
				'title' => 'Дата',
				'value' => function(Post $p) {
					return date('d.m.Y - H:i', $p->getTimestamp());
				}
			],
			'published' => 'Опубликовано',
		];
	}

	/**
	 * @param Form $form
	 * @param Post $entity
	 */
	protected function buildForm(Form $form, Entity $entity)
	{
		$postCategories = [];
		/** @var Category $c */
		foreach ($this->getCategoryService()->getPostCategories($entity) as $c) {
			$postCategories[] = $c->getId();
		}

		$form
			->add('title', 'text', [
				'label' => 'Заголовок',
				'required' => true,
				'data' => $entity->getTitle(),
			])
			->add('text', 'textarea', [
				'label' => 'Текст',
				'data' => $entity->getText(),
				'attr' => [
					'data-wysiwyg' => true,
				],
			])
			->add('published', 'checkbox', [
				'label' => 'Опубликовано',
				'data' => $entity->getPublished(),
			])
			->add('timestamp', 'timestamp', [
				'label' => 'Дата публикации',
				'withTime' => true,
				'data' => $entity->getId() ? $entity->getTimestamp() : time(),
			])
			->add('categories', 'hidden', [
				'data' => implode(',', $postCategories),
			]);
	}

	/**
	 * @param Post $entity
	 * @param Form $form
	 * @param array $exclude
	 */
	protected function save(Entity $entity, Form $form, array $exclude = array())
	{
		$categoriesString = $form->get('categories')->getData();

		$form->remove('categories');
		$entity->setUserId($this->getCurrentUser()->getId());
		parent::save($entity, $form, $exclude);

		$this->getCategoryService()->setPostCategories($entity, explode(',', $categoriesString));
	}

	protected function getEditTemplate()
	{
		return 'ContentBundle/Views/AdminPost/edit.twig';
	}

	protected function getTemplateParameters(array $parameters = [])
	{
		$categories = [];

		/** @var Category $c */
		foreach ($this->getCategoryService()->getCategories() as $c) {
			$categories[] = ['id' => $c->getId(), 'name' => $c->getName()];
		}

		return parent::getTemplateParameters($parameters) + [
			'categories' => json_encode($categories),
		];
	}

	protected function getRoutes()
	{
		return [
			'add' => '_admin_post_add',
			'edit' => '_admin_post_edit',
			'delete' => '_admin_post_delete',
		];
	}

	protected function getManager()
	{
		return $this->getPostManager();
	}

}