<?php

namespace ContentBundle\Service;

use BaseBundle\Utils\DateFormatter;
use ContentBundle\BundleTrait;
use ContentBundle\Entity\Category;
use ContentBundle\Entity\Post;
use ContentBundle\Manager\PostManager;
use Svi\AppContainer;

class PostService extends AppContainer
{
    use BundleTrait;
    use \CommentsBundle\BundleTrait;

	/**
	 * @param $alias
	 * @return Post
	 */
	public function getPostByAlias($alias)
	{
		return $this->getPostManager()->findOneByAlias($alias);
	}

	public function getPostsCount(Category $category = null, $search = null)
	{
		$db = $this->getPostsQuery($category, $search);
		$db->select('COUNT(p.id)');

		return $db->execute()->fetchColumn(0);
	}

	public function getPosts(Category $category = null, $search = null, $page = 0, $itemsPerPage = 10)
	{
		$db = $this->getPostsQuery($category, $search)
			->orderBy('p.timestamp', 'desc')
			->setMaxResults($itemsPerPage)
			->setFirstResult($page * $itemsPerPage);

		$result = [];
		foreach ($db->execute()->fetchAll() as $p) {
			$result[] = $this->getPostForTemplate($this->getManager()->fillByData($p), true);
		}
		return $result;
	}

	public function getPostForTemplate(Post $post, $forList = false)
	{
		$categories = array();
		/** @var Category $c */
		foreach ($this->getCategoryService()->getPostCategories($post) as $c) {
			$categories[] = [
				'id' => $c->getId(),
				'name' => $c->getName(),
			];
		}

		return array(
			'id' => $post->getId(),
			'title' => $post->getTitle(),
			'text' => $forList ? $post->getShortenedText() : $post->getFullText(),
			'timestamp' => $post->getTimestamp(),
			'date' => new DateFormatter($post->getTimestamp(), true),
			'categories' => $categories,
			'comments' => $this->getCommentsService()->getPostCommentsForTemplate($post),
			'commentsCount' => $post->getCommentsCount(),
		);
	}

	/**
	 * @param $id
	 * @return Post
	 */
	public function getPost($id)
	{
		return $this->getManager()->findOneById($id);
	}

	protected function getPostsQuery(Category $category = null, $search = null)
	{
		$db = $this->getManager()->getConnection()->createQueryBuilder()->select('p.*')->from('post', 'p');
		$db->andWhere('p.published = 1 AND p.removed = 0');
		if ($category) {
			$db->andWhere('(SELECT COUNT(pc.id) FROM post_category pc WHERE pc.post_id = p.id AND pc.category_id = ' . $category->getId() . ') > 0');
		}
		if ($search) {
			$db
				->andWhere('p.title LIKE :search OR p.text LIKE :search')
				->setParameter('search', '%' . $search . '%');
		}

		return $db;
	}

	/**
	 * @return PostManager
	 */
	protected function getManager()
	{
		return $this->getPostManager();
	}

}