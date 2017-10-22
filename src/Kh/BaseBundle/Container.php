<?php

namespace Kh\BaseBundle;

class Container extends \Svi\BaseBundle\Container
{

	/**
	 * @return \Kh\UserBundle\Bundle
	 */
	public function getUserBundle()
	{
		return $this->getApp()[\Kh\UserBundle\Bundle::class];
	}

	/**
	 * @return \Kh\PromoBundle\Bundle
	 */
	public function getPromoBundle()
	{
		return $this->getApp()[\Kh\PromoBundle\Bundle::class];
	}

	/**
	 * @return \Kh\MailBundle\Bundle
	 */
	public function getMailBundle()
	{
		return $this->getApp()[\Kh\MailBundle\Bundle::class];
	}

	/**
	 * @return \Kh\ContentBundle\Bundle
	 */
	public function getContentBundle()
	{
		return $this->getApp()[\Kh\ContentBundle\Bundle::class];
	}

	/**
	 * @return \Kh\CommentsBundle\Bundle
	 */
	public function getCommentsBundle()
	{
		return $this->getApp()[\Kh\CommentsBundle\Bundle::class];
	}

}