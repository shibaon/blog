<?php

namespace Kh\BaseBundle;

use Kh\CommentsBundle\Service\CommentsService;
use Kh\CommentsBundle\Service\CommentsSubscriptionService;
use Kh\ContentBundle\Service\CategoryService;
use Kh\ContentBundle\Service\PostService;
use Kh\MailBundle\Service\MailService;
use Kh\PromoBundle\Service\MenuService;
use Kh\PromoBundle\Service\PageService;
use Kh\UserBundle\Service\AuthorizationService;
use Kh\UserBundle\Service\UserService;

class Container extends \Svi\Base\Container
{

	/**
	 * @return UserService
	 */
	public function getUserService()
	{
		return $this->getApp()->get('service.user');
	}

	/**
	 * @return MailService
	 */
	public function getMailService()
	{
		return $this->getApp()->get('service.mail');
	}

	/**
	 * @return MenuService
	 */
	public function getMenuService()
	{
		return $this->getApp()->get('service.menu');
	}

	/**
	 * @return PageService
	 */
	public function getPageService()
	{
		return $this->getApp()->get('service.page');
	}

	/**
	 * @return AuthorizationService
	 */
	public function getAuthorizationService()
	{
		return $this->getApp()->get('service.authorization');
	}

	/**
	 * @return PostService
	 */
	public function getPostService()
	{
		return $this->getApp()->get('service.post');
	}

	/**
	 * @return CategoryService
	 */
	public function getCategoryService()
	{
		return $this->getApp()->get('service.category');
	}

	/**
	 * @return CommentsService
	 */
	public function getCommentsService()
	{
		return $this->getApp()->get('service.comments');
	}

	/**
	 * @return CommentsSubscriptionService
	 */
	public function getCommentsSubscriptionService()
	{
		return $this->getApp()->get('service.comments_subscription');
	}

} 