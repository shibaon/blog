<?php

namespace Kh\BaseBundle;

class Container extends \Svi\Base\Container
{

	/**
	 * @return \Kh\UserBundle\Bundle
	 */
	public function getUserBundle()
	{
		return $this->getApp()->get(\Kh\UserBundle\Bundle::class);
	}

	/**
	 * @return \Kh\PromoBundle\Bundle
	 */
	public function getPromoBundle()
	{
		return $this->getApp()->get(\Kh\PromoBundle\Bundle::class);
	}

	/**
	 * @return \Kh\MailBundle\Bundle
	 */
	public function getMailBundle()
	{
		return $this->getApp()->get(\Kh\MailBundle\Bundle::class);
	}

	/**
	 * @return \Kh\ContentBundle\Bundle
	 */
	public function getContentBundle()
	{
		return $this->getApp()->get(\Kh\ContentBundle\Bundle::class);
	}

	/**
	 * @return \Kh\CommentsBundle\Bundle
	 */
	public function getCommentsBundle()
	{
		return $this->getApp()->get(\Kh\CommentsBundle\Bundle::class);
	}

} 