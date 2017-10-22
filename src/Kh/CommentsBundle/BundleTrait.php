<?php

namespace Kh\CommentsBundle;

use Kh\CommentsBundle\Manager\CommentManager;
use Kh\CommentsBundle\Manager\SubscriptionManager;
use Kh\CommentsBundle\Service\CommentsService;
use Kh\CommentsBundle\Service\CommentsSubscriptionService;

trait BundleTrait
{
    use \Svi\Service\BundlesService\BundleTrait;

    /**
     * @return CommentsService
     */
    public function getCommentsService()
    {
        return $this->get(CommentsService::class);
    }

    /**
     * @return CommentsSubscriptionService
     */
    public function getCommentsSubscriptionService()
    {
        return $this->get(CommentsSubscriptionService::class);
    }

    /**
     * @return CommentManager
     */
    public function getCommentManager()
    {
        return $this->get(CommentManager::class);
    }

    /**
     * @return SubscriptionManager
     */
    public function getCommentsSubscriptionManager()
    {
        return $this->get(SubscriptionManager::class);
    }
}