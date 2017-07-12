<?php

namespace Kh\BaseBundle;

class Container extends \Svi\Base\Container
{

	/**
	 * @return \Kh\UserBundle\Bundle
	 */
	public function getUserBundle()
	{
		return $this->getApp()->get('bundle.khuser');
	}

	/**
	 * @return \Kh\PromoBundle\Bundle
	 */
	public function getPromoBundle()
	{
		return $this->getApp()->get('bundle.khpromo');
	}

	/**
	 * @return \Kh\MailBundle\Bundle
	 */
	public function getMailBundle()
	{
		return $this->getApp()->get('bundle.khmail');
	}

	/**
	 * @return \Kh\ContentBundle\Bundle
	 */
	public function getContentBundle()
	{
		return $this->getApp()->get('bundle.khcontent');
	}

	/**
	 * @return \Kh\CommentsBundle\Bundle
	 */
	public function getCommentsBundle()
	{
		return $this->getApp()->get('bundle.khcomments');
	}

} 