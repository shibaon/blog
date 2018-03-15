<?php

namespace CommentsBundle;

use CommentsBundle\Manager\CommentManager;
use CommentsBundle\Manager\SubscriptionManager;
use CommentsBundle\Service\CommentsService;
use CommentsBundle\Service\CommentsSubscriptionService;

trait BundleTrait
{
    /**
     * @return CommentsService
     */
    public function getCommentsService()
    {
        return $this->app[CommentsService::class];
    }

    /**
     * @return CommentsSubscriptionService
     */
    public function getCommentsSubscriptionService()
    {
        return $this->app[CommentsSubscriptionService::class];
    }

    /**
     * @return CommentManager
     */
    public function getCommentManager()
    {
        return $this->app[CommentManager::class];
    }

    /**
     * @return SubscriptionManager
     */
    public function getCommentsSubscriptionManager()
    {
        return $this->app[SubscriptionManager::class];
    }
}