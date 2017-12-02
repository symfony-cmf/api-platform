<?php

namespace Symfony\Cmf\Bundle\ApiPlatformBundle\Metadata\Property;

use ApiPlatform\Core\Metadata\Property\Factory\PropertyMetadataFactoryInterface;
use ApiPlatform\Core\Metadata\Property\PropertyMetadata;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class DoctrinePhcrPropertyMetadataFactory implements PropertyMetadataFactoryInterface
{
    private $decorated;
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry, PropertyMetadataFactoryInterface $decorated = null)
    {
        $this->managerRegistry = $managerRegistry;
        $this->decorated = $decorated;
    }
    /**
     * {@inheritdoc}
     */
    public function create(string $resourceClass, string $property, array $options = []) : PropertyMetadata
    {
        $itemMetadata = $this->decorated->create($resourceClass, $property, $options);
        if (null !== $itemMetadata->isIdentifier()) {
            return $itemMetadata;
        }
        $manager = $this->managerRegistry->getManagerForClass($resourceClass);
        if (!$manager) {
            return $itemMetadata;
        }

        /** @var ClassMetadata $doctrineClassMetadata */
        $doctrineClassMetadata = $manager->getClassMetadata($resourceClass);
        if (!$doctrineClassMetadata) {
            return $itemMetadata;
        }
        $identifiers = $doctrineClassMetadata->getIdentifier();
        foreach ($identifiers as $identifier) {
            if ($identifier === $property) {
                $itemMetadata = $itemMetadata->withIdentifier(true);
                $itemMetadata = $itemMetadata->withReadable(false);
                $itemMetadata = $itemMetadata->withWritable($doctrineClassMetadata->isIdGeneratorNone());
                break;
            }
        }
        if (null === $itemMetadata->isIdentifier()) {
            $itemMetadata = $itemMetadata->withIdentifier(false);
        }

        return $itemMetadata;
    }
}
