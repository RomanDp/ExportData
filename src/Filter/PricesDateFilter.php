<?php

namespace App\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Core\Exception\InvalidArgumentException;
use App\Entity\Price\Item;
use Doctrine\ORM\QueryBuilder;

class PricesDateFilter extends AbstractFilter
{
    protected function filterProperty(
        string $property,
        $value,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        string $operationName = null
    )
    {
        if ($value === null || $property !== 'date') {
            return;
        }

        try {
            $value = new \DateTime($value);
        } catch (\Exception $e) {
            // Silently ignore this filter if it can not be transformed to a \DateTime
            $this->logger->notice('Invalid filter ignored', [
                'exception' => new InvalidArgumentException(sprintf('The field "publishedAt" has a wrong date format. Use one accepted by the \DateTime constructor')),
            ]);

            return;
        }

        $parameterName = $queryNameGenerator->generateParameterName($property);

        $queryBuilder
            ->addSelect($parameterName)
            ->leftJoin('o.items', $parameterName, 'WITH', 'DATE(' . $parameterName . '.publishedAt) = :' . $parameterName)
            ->setParameter($parameterName, $value, 'date');
    }

    // This function is only used to hook in documentation generators (supported by Swagger and Hydra)
    public function getDescription(string $resourceClass): array
    {
        return [
            'commodity_date' => [
                'property' => 'publishedAt',
                'type' => \DateTimeInterface::class,
                'required' => false,
                'swagger' => [
                    'description' => 'Filter by "' . Item::class . '" publishedAt.',
                    'name' => 'date',
                    'type' => \DateTimeInterface::class
                ],
            ]
        ];
    }
}