<?php

namespace ApiSkeletons\Doctrine\GraphQL\Resolve;

use ApiSkeletons\Doctrine\GraphQL\Context;

class Loader
{
    protected $resolveManager;

    public function __construct(ResolveManager $resolveManager)
    {
        $this->resolveManager = $resolveManager;
    }

    public function __invoke(string $name, Context $context = null)
    {
        $context = $context ?? new Context();

        return $this->resolveManager->build($name, $context->toArray());
    }
}
