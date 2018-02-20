<?php

namespace App\Entity\Price;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Selectable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Table(name="greport", schema="price")
 * @ORM\Entity(repositoryClass="App\Repository\Price\ReportRepository")
 *
 * @ApiResource(
 *     attributes={
 *         "normalization_context"={"groups"={"report"}}
 *     },
 *     itemOperations={
 *         "get"={
 *             "method"="GET"
 *         },
 *         "download_reports"={
 *             "method"="GET",
 *             "route_name"="api_reporting_download_result",
 *             "swagger_context" = {
 *                 "summary" = "Download reports for group per given file path.",
 *                 "parameters" = {
 *                     {
 *                         "name" = "filename",
 *                         "in" = "path",
 *                         "required" = true,
 *                         "type" = "string"
 *                     }
 *                 },
 *                 "responses" = {
 *                     200 = {
 *                         "schema" = {"type" = "file"}
 *                     }
 *                 }
 *             }
 *         }
 *     }
 * )
 * @ApiFilter(SearchFilter::class, properties={"id"="exact", "group"="exact", "name"="partial"})
 */
class Report
{
    /**
     * @var string
     * @ORM\Column(name="greport", type="guid")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Groups({"report", "group"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="reports")
     * @ORM\JoinColumn(name="cod_gr", referencedColumnName="cod_gr", nullable=false)
     *
     * @Groups({"report"})
     *
     * @var Group
     */
    private $group;

    /**
     * @var string
     * @ORM\Column(type="string", name="name")
     *
     * @Groups({"report", "group"})
     */
    private $name;

    /**
     * @var integer
     * @ORM\Column(type="integer", name="sort_order", options={"default": 0})
     * @Groups({"report", "group"})
     */
    private $position;

    /**
     * @var string
     * @ORM\Column(type="text", name="jgenerator")
     *
     * @Groups({"report", "group"})
     */
    private $generatorClass;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="ReportLine", mappedBy="report")
     *
     * @Groups({"report"})
     */
    private $lines;

    public function __construct()
    {
        $this->position = 0;
        $this->lines = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): ? string
    {
        return $this->id;
    }

    /**
     * @return Group
     */
    public function getGroup(): ? Group
    {
        return $this->group;
    }

    /**
     * @param Group $group
     */
    public function setGroup(Group $group): void
    {
        $this->group = $group;
    }

    /**
     * @return string
     */
    public function getName(): ? string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getPosition(): ? int
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    /**
     * @return string
     */
    public function getGeneratorClass(): ? string
    {
        //FIXME: брать значения из базы
        return 'PlantsGenerator';
        return $this->generatorClass;
    }

    /**
     * @param string $generatorClass
     */
    public function setGeneratorClass(string $generatorClass): void
    {
        $this->generatorClass = $generatorClass;
    }

    /**
     * @param ReportLine $reportLine
     */
    public function addLine(ReportLine $reportLine)
    {
        $this->lines[] = $reportLine;
    }

    /**
     * @param ReportLine $reportLine
     */
    public function removeLine(ReportLine $reportLine)
    {
        $this->lines->removeElement($reportLine);
    }

    /**
     * @return Collection|Selectable|ReportLine[]
     */
    public function getLines(): Collection
    {
        return $this->lines;
    }
}
