<?php


namespace App\Doctrine;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;

class EntityIdGenerator extends AbstractIdGenerator
{

    private $sequenceName;

    public function __construct($sequenceName)
    {
        $this->sequenceName = $sequenceName;
    }

    /**
     * Generates an identifier for an entity.
     *
     * @param EntityManager|EntityManager  $em
     * @param \Doctrine\ORM\Mapping\Entity $entity
     *
     * @return mixed
     */
    public function generate(EntityManager $em, $entity)
    {
        // TODO: Implement generate() method.
    }

}
