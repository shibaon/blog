<?php

namespace Kh\ContentBundle\Service;

use Kh\BaseBundle\ContainerAware;
use Kh\ContentBundle\Entity\Category;
use Kh\ContentBundle\Entity\Post;
use Kh\ContentBundle\Entity\PostCategory;
use Kh\ContentBundle\Manager\CategoryManager;
use Kh\ContentBundle\Manager\PostCategoryManager;

class CategoryService extends ContainerAware
{

	public function setPostCategories(Post $post, array $categoriesIds)
	{
		$executed = [];

		foreach ($categoriesIds as $id) {
			$id = intval(trim($id));
			if (!($category = $this->getCategory($id)) || array_key_exists($category->getId(), $executed)) {
				continue;
			}
			$executed[$category->getId()] = true;
			$link = PostCategoryManager::getInstance()->findOneBy(['post_id' => $post->getId(), 'category_id' => $category->getId()]);
			if (!$link) {
				$link = new PostCategory();
				$link
					->setPostId($post->getId())
					->setCategoryId($category->getId());
				PostCategoryManager::getInstance()->save($link);
			}
		}

		$this->getManager()->getConnection()->executeQuery('DELETE FROM post_category WHERE post_id = ' . $post->getId() . ' ' .
			(count($executed) ?
				'AND category_id NOT IN (' . implode(',', array_keys($executed)) . ')' : ''
			)
		);
	}

	public function updateCategoryPostsCount(Category $category)
	{
		$category->setPostsCount($this->c->getPostService()->getPostsCount($category))->save();
	}

	public function deleteCategory(Category $category, Category $moveTo = null)
	{
		if ($moveTo && $category->getId() != $moveTo->getId()) {
			$this->movePosts($category, $moveTo);
		}
		$this->getManager()->getConnection()->executeQuery('DELETE FROM post_category WHERE category_id = ' . $category->getId());
		$this->getManager()->delete($category);
		if ($moveTo) {
			$this->updateCategoryPostsCount($moveTo);
		}
	}

	public function movePosts(Category $from, Category $to)
	{
		$this->getManager()->getConnection()->executeQuery('UPDATE post_category SET category_id = ' . $to->getId() . ' WHERE category_id = ' . $from->getId());
	}

	/**
	 * @param $id
	 * @return Category
	 */
	public function getCategory($id)
	{
		return $this->getManager()->findOneById($id);
	}

	public function getCategories()
	{
		return $this->getManager()->findBy([], ['name' => 'asc']);
	}

	public function getCategoriesForSelect()
	{
		$result = [];
		/** @var Category $c */
		foreach ($this->getCategories() as $c) {
			$result[$c->getId()] = $c->getName();
		}

		return $result;
	}

	public function getPostCategories(Post $post)
	{
		$result = [];
		/** @var PostCategory $pc */
		foreach ($this->getPostCategoryManager()->findByPostId($post->getId()) as $pc) {
			$result[] = $this->getManager()->findOneById($pc->getCategoryId());
		}

		return $result;
	}

	/**
	 * @return CategoryManager
	 */
	protected function getManager()
	{
		return $this->c->getContentBundle()->getCategoryManager();
	}

	/**
	 * @return PostCategoryManager
	 */
	protected function getPostCategoryManager()
	{
		return $this->c->getContentBundle()->getPostCategoryManager();
	}

}