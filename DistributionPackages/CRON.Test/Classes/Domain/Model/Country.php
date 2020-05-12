<?php
namespace CRON\Test\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use Neos\Flow\Annotations as Flow;

/**
 * @Flow\Entity
 * @ORM\Table(indexes={@ORM\Index(name="sorting_idx", columns={"sorting"})})
 */
class Country
{

    /**
     * @var string
     * @ORM\Column(unique=true)
     * @Flow\Validate(type="NotEmpty")
     */
    protected $name;

    /**
     * ISO Code according to ISO 3166-1:Alpha-2 code
     *
     * @var string
     * @ORM\Column(length=2, unique=true)
     * @Flow\Validate(type="NotEmpty")
     */
    protected $iso;

    /**
     * Klopotek Code, according to Documentation
     *
     * @var string
     * @ORM\Column(length=4, unique=true)
     * @Flow\Validate(type="NotEmpty")
     */
    protected $klopotek;

    /**
     * Klopotek region.
     * ACHTUNG: The postages flag "region=Y/N" is disregarded for this, so that "Deutschland" is also a "region".
     *
     * @var string
     * @Flow\Validate(type="NotEmpty")
     */
    protected $region;

    /**
     * Defines the order in which countries are displayed
     *
     * @var int
     * @ORM\Column
     */
    protected $sorting;

    /**
     * Defines the shipping cost for this country
     *
     * @var float
     * @ORM\Column(name="shipping_cost")
     */
    protected $shippingCost;

    /**
     * String representation of Country (name)
     *
     * @return string
     */
    public function __toString()
    {

        return $this->getName();
    }

    /**
     * @return string
     */
    public function getName()
    {

        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Country
     */
    public function setName($name)
    {

        $this->name = $name;

        return $this;
    }

}
