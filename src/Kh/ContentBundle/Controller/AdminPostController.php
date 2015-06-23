<?php

namespace Kh\ContentBundle\Controller;

use Kh\AdminBundle\Controller\CrudController;
use Kh\ContentBundle\Entity\Category;
use Kh\ContentBundle\Entity\Post;
use Sv\BaseBundle\Forms\Form;
use Svi\Entity;

class AdminPostController extends CrudController
{

	protected function getListColumns()
	{
		return [
			'id' => '#',
			'title' => [
				'title' => 'Заголовок',
				'value' => function(Post $post){
					return [
						'type' => 'link',
						'href' => $this->c->getRouting()->getUrl('_post', ['id' => $post->getId()]),
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
	protected function buildForm(Form $form, $entity)
	{
		$postCategories = [];
		/** @var Category $c */
		foreach ($this->c->getCategoryManager()->getPostCategories($entity) as $c) {
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
		parent::save($entity, $form, $exclude);

		$this->c->getCategoryManager()->setPostCategories($entity, explode(',', $categoriesString));
	}

	protected function getEditTemplate()
	{
		return 'Kh/ContentBundle/Views/AdminPost/edit.twig';
	}

	protected function getTemplateParameters(array $parameters = [])
	{
		$categories = [];

		/** @var Category $c */
		foreach ($this->c->getCategoryManager()->getCategories() as $c) {
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

	protected function getClassName()
	{
		return 'Kh\\ContentBundle\\Entity\\Post';
	}

}