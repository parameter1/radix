<?php

namespace AppBundle\EventSubscriber\Customer;

use As3\Modlr\Events\EventSubscriberInterface;
use As3\Modlr\Models\Model;
use As3\Modlr\Store\Events;
use As3\Modlr\Store\Events\ModelLifecycleArguments;
use As3\Modlr\Store\Store;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CustomerAnswerSubscriber extends AbstractCustomerSubscriber implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    protected function shouldProcess(Model $model)
    {
        return 0 === stripos($model->getType(), 'customer-answer-');
    }

    /**
     * {@inheritdoc}
     */
    protected function handleEventsFor(Model $model)
    {

    }

    /**
     * {@inheritdoc}
     */
    protected function getFactory()
    {
        return $this->container->get('app_bundle.factory.customer_answer');
    }
}
