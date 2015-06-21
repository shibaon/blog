<?php

namespace Kh\BaseBundle;

use Kh\CommentsBundle\CommentsManager;
use Kh\CommentsBundle\CommentsSubscriptionManager;
use Kh\ContentBundle\CategoryManager;
use Kh\ContentBundle\PostManager;
use Kh\PromoBundle\MenuManager;
use Kh\MailBundle\MailManager;
use Kh\PromoBundle\PageManager;
use Kh\UserBundle\AuthorizationManager;
use Kh\UserBundle\UserManager;

class Container extends \Sv\BaseBundle\Container
{

	/**
	 * @return UserManager
	 */
	public function getUserManager()
	{
		return $this->getApp()->get('manager.user');
	}

	/**
	 * @return MailManager
	 */
	public function getMailManager()
	{
		return $this->getApp()->get('manager.mail');
	}

	/**
	 * @return MenuManager
	 */
	public function getMenuManager()
	{
		return $this->getApp()->get('manager.menu');
	}

	/**
	 * @return PageManager
	 */
	public function getPageManager()
	{
		return $this->getApp()->get('manager.page');
	}

	/**
	 * @return AuthorizationManager
	 */
	public function getAuthorizationManager()
	{
		return $this->getApp()->get('manager.authorization');
	}

	/**
	 * @return PostManager
	 */
	public function getPostManager()
	{
		return $this->getApp()->get('manager.post');
	}

	/**
	 * @return CategoryManager
	 */
	public function getCategoryManager()
	{
		return $this->getApp()->get('manager.category');
	}

	/**
	 * @return CommentsManager
	 */
	public function getCommentsManager()
	{
		return $this->getApp()->get('manager.comments');
	}

	/**
	 * @return CommentsSubscriptionManager
	 */
	public function getCommentsSubscriptionManager()
	{
		return $this->getApp()->get('manager.comments_subscription');
	}

} 