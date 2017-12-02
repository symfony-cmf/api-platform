<?php

namespace Symfony\Cmf\Component\ApiPlatform\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotFoundException;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class PhpcrOdmProvider implements ItemDataProviderInterface
{

    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    /**
     * @var ItemDataProviderInterface
     */
    private $decorated;


    public function __construct(ManagerRegistry $managerRegistry, ItemDataProviderInterface $decorated = null)
    {
        $this->managerRegistry = $managerRegistry;
        $this->decorated = $decorated;
    }

    /**
     * {@inheritdoc}
     *
     * @throws ResourceClassNotSupportedException
     *
     * @return object|null
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        if ($this->decorated) {
            try {
                return $this->decorated->getItem($resourceClass, $id, $operationName, $context);
            } catch (ResourceClassNotFoundException $e) {
                // ignore it
            }
        }

        $manager = $this->managerRegistry->getManagerForClass($resourceClass);
        if (null === $manager) {
            throw new ResourceClassNotSupportedException(sprintf(
                'No manager found to handle class "%s" ',
                $resourceClass
            ));
        }

        $document = $manager->find($resourceClass, $id);
        if (null === $document) {
            throw new ResourceClassNotFoundException(sprintf(
                'No document found for class "%" and id/path "%s"',
                $resourceClass,
                $id
            ));
        }

        return $document;
    }
}
