<?php

namespace App\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;

class PricesGroupFilter extends AbstractFilter
{
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        if ($value === null || $property !== 'group') {
            return;
        }

        $parameterName = $queryNameGenerator->generateParameterName($property);

        $queryBuilder
            ->join('o.groupCommodities', $parameterName, 'WITH', $parameterName.'.group = :'.$parameterName)
            ->setParameter($parameterName, $value)
            ->orderBy($parameterName.'.position');
    }

    // This function is only used to hook in documentation generators (supported by Swagger and Hydra)
    public function getDescription(string $resourceClass): array
    {
        return [
            'commodity_group' => [
                'property' => 'groupCommodities',
                'type' => 'string',
                'required' => false,
                'swagger' => [
                    'description' => 'Filter by commodity group.',
                    'name' => 'group',
                ],
            ],
        ];
    }
}