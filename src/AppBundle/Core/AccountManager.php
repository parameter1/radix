<?php

namespace AppBundle\Core;

use As3\Modlr\Models\Model;
use As3\Modlr\Store\Store;

class AccountManager
{
    /**
     * @var Model|null
     */
    private $account;

    /**
     * @var Model|null
     */
    private $application;

    /**
     * @var Store
     */
    private $store;

    /**
     * @param   Store   $store
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    /**
     * @return  bool
     */
    public function hasApplication()
    {
        return null !== $this->application;
    }

    /**
     * @return  string|null
     */
    public function getCompositeKey()
    {
        if (false === $this->hasApplication()) {
            return;
        }
        return sprintf('%s:%s', $this->account->get('key'), $this->application->get('key'));
    }

    public function retrieveByAppKey($appKey)
    {
        $parts = explode(':', $appKey);
        if (2 !== count($parts) || empty($parts[0]) || empty($parts[1])) {
            throw new \InvalidArgumentException('Invalid app key.');
        }
        $account = $this->store->findQuery('core-account', ['key' => $parts[0]])->getSingleResult();
        if (null === $account) {
            return;
        }
        $criteria = ['account' => $account->getId(), 'key' => $parts[1]];
        return $this->store->findQuery('core-application', $criteria)->getSingleResult();
    }

    /**
     * @param   string  $publicKey
     * @return  Model|null
     */
    public function retrieveByPublicKey($publicKey)
    {
        return $this->store->findQuery('core-application', ['publicKey' => $publicKey])->getSingleResult();
    }

    /**
     * @param   Model   $application
     * @return  self
     */
    public function setApplication(Model $application)
    {
        $this->application = $application;
        $this->account     = $application->get('account');
        return $this;
    }
}
