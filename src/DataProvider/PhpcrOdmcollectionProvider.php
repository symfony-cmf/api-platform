<?php

namespace Symfony\Cmf\Component\ApiPlatform\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotFoundException;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class PhpcrOdmcollectionProvider implements CollectionDataProviderInterface
{
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    /**
     * @var CollectionDataProviderInterface
     */
    private $decorated;

    public function __construct(ManagerRegistry $managerRegistry, CollectionDataProviderInterface $decorated = null)
    {
        $this->managerRegistry = $managerRegistry;
        $this->decorated = $decorated;
    }

    /**
     * Retrieves a collection.
     *
     * @param string $resourceClass
     * @param string|null $operationName
     *
     * @throws ResourceClassNotSupportedException
     *
     * @return array|\Traversable
     */
    public function getCollection(string $resourceClass, string $operationName = null)
    {
        if ($this->decorated) {
            try {
                return $this->decorated->getCollection($resourceClass, $operationName);
            } catch (ResourceClassNotFoundException $e) {
                // ignore it
            }
        }
        $repository = $this->managerRegistry->getRepository($resourceClass);

        return $repository->findAll();
    }
}
