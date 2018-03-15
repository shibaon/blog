<?php

namespace MailBundle;

use MailBundle\Service\MailService;

trait BundleTrait
{

    /**
     * @return MailService
     */
    public function getMailService()
    {
        return $this->app[MailService::class];
    }

}