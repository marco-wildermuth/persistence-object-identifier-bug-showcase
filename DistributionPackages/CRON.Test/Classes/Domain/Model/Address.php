<?php
namespace CRON\Test\Domain\Model;

/*                                                                        *
 * This script belongs to the Neos Flow package "CRON.DavShop".          *
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;

/**
 * Address Class
 *
 * @package CRON\Test\Domain\Model
 */
class Address
{

    /**
     * @var string
     */
    protected $salutation;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     * @Flow\Validate(type="NotEmpty")
     */
    protected $firstName;

    /**
     * @var string
     * @Flow\Validate(type="NotEmpty")
     */
    protected $name;

    /**
     * @var string
     */
    protected $institution;

    /**
     * @var string
     */
    protected $department;

    /**
     * @var string
     */
    protected $address;

    /**
     * @var string
     */
    protected $addressAddition;

    /**
     * @var bool
     */
    protected $packstation = false;

    /**
     * @var string
     */
    protected $packstationNumber;

    /**
     * @var string
     */
    protected $packstationPostNummer;

    /**
     * @var string
     * @Flow\Validate(type="NotEmpty")
     */
    protected $postalCode;

    /**
     * @var string
     * @Flow\Validate(type="NotEmpty")
     */
    protected $city;

    /**
     * @var Country
     * @Flow\Validate(type="NotEmpty")
     */
    protected $country;

    /**
     * @var string
     */
    protected $emailAddress;

    /**
     * Returns an md5 "identifier" for the Address
     *
     * @return string
     */
    public function getIdentifier()
    {

        return md5($this->toString());
    }

    /**
     * String representation of Address
     *
     * @return string
     */
    public function __toString()
    {

        return $this->toString();
    }

    /**
     * String representation of Address
     *
     * @param string $separator
     *
     * @return string
     */
    public function toString($separator = ', ')
    {

        $parts = $this->isPackstation() ? [
            $this->getInstitution(),
            $this->getDepartment(),
            $this->getFullNameWithTitle(),
            $this->getPackstationPostNummer(),
            'Packstation '.$this->getPackstationNumber(),
            implode(' ', array_filter([$this->getPostalCode(), $this->getCity()])),
            $this->getCountry(),
        ] : [
            $this->getInstitution(),
            $this->getDepartment(),
            $this->getFullNameWithTitle(),
            $this->getAddress(),
            $this->getAddressAddition(),
            implode(' ', array_filter([$this->getPostalCode(), $this->getCity()])),
            $this->getCountry(),
        ];
        return implode($separator, array_filter($parts));
    }

    /**
     * @return string
     */
    public function getSalutation()
    {
        return $this->salutation;
    }

    /**
     * @param string $salutation
     * @return Address
     */
    public function setSalutation($salutation)
    {
        $this->salutation = $salutation;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Address
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return Address
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
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
     * @return Address
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * @param string $institution
     *
     * @return Address
     */
    public function setInstitution($institution)
    {
        $this->institution = $institution;
        return $this;
    }

    /**
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param string $department
     * @return Address
     */
    public function setDepartment($department)
    {
        $this->department = $department;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {

        return $this->address;
    }

    /**
     * @param string $address
     *
     * @return Address
     */
    public function setAddress($address)
    {

        $this->address = $address;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddressAddition()
    {
        return $this->addressAddition;
    }

    /**
     * @param string $addressAddition
     * @return Address
     */
    public function setAddressAddition($addressAddition)
    {
        $this->addressAddition = $addressAddition;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isPackstation()
    {
        return $this->packstation;
    }

    /**
     * @param boolean $packstation
     * @return Address
     */
    public function setPackstation($packstation)
    {
        $this->packstation = $packstation;
        if ($this->packstation) {
            $this
                ->setAddress(null)
                ->setAddressAddition(null)
            ;
        } else {
            $this
                ->setPackstationPostNummer(null)
                ->setPackstationNumber(null)
            ;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getPackstationNumber()
    {
        return $this->packstationNumber;
    }

    /**
     * @param string $packstationNumber
     * @return Address
     */
    public function setPackstationNumber($packstationNumber)
    {
        $this->packstationNumber = $packstationNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getPackstationPostNummer()
    {
        return $this->packstationPostNummer;
    }

    /**
     * @param string $packstationPostNummer
     * @return Address
     */
    public function setPackstationPostNummer($packstationPostNummer)
    {
        $this->packstationPostNummer = $packstationPostNummer;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     * @return Address
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     *
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return \CRON\Test\Domain\Model\Country
     */
    public function getCountry()
    {

        return $this->country;
    }

    /**
     * @param \CRON\Test\Domain\Model\Country $country
     *
     * @return Address
     */
    public function setCountry($country)
    {

        $this->country = $country;

        return $this;
    }

    /**
     * Returns the Customer's Email Address (to be used only for Anonymous Customers!!)
     *
     * @return string
     */
    public function getEmailAddress()
    {

        return $this->emailAddress;
    }

    /**
     * Saves the Customer's Email Address (to be used only for Anonymous Customers!!)
     *
     * @param string $emailAddress
     */
    public function setEmailAddress($emailAddress)
    {

        $this->emailAddress = $emailAddress;
    }

    /**
     * Returns the full name with title and title addition
     *
     * @return string
     */
    public function getFullNameWithTitle()
    {
        return implode(' ', array_filter(
            [
                $this->getSalutation(),
                $this->getTitle(),
                $this->getFirstName(),
                $this->getName()
            ]));
    }
}
