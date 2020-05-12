<?php
namespace CRON\Test\Domain\Model;

use Neos\Flow\Annotations as Flow;

/**
 * @see \CRON\Test\Domain\Aspect\CustomerSessionAspect
 */
class Customer
{
    /**
     * @var string
     */
    protected $customerNumber;

    /**
     * @var string
     */
    protected $telephone;

    /**
     * @var string
     */
    protected $jobDescription;

    /**
     * @var string
     * @Flow\Identity
     */
    protected $auth0Id;

    /**
     * @var Address
     */
    protected $billingAddress;

    /**
     * Contains all the user's delivery addresses
     *
     * @var Address[]
     */
    protected $deliveryAddresses = [];

    /**
     * @var string
     */
    protected $emailAddress;

    /**
     * @var bool
     */
    protected $persistent = true;

    /**
     * Contains the Klopotek Payment Flag for this Customer, if any
     *
     * Note: for "Lastschrift" payment, this flag will contain the last digits of the
     * bank account.
     *
     * @var string
     */
    protected $paymentFlag;

    /**
     * @var bool
     */
    protected $klopotekCustomer = false;

    /**
     * Customer constructor.
     */
    public function __construct()
    {
        $this->deliveryAddresses = [];
    }

    /**
     * Returns the Customer's Identifier
     *
     * Used by Ciando Gateway (max 30 chars)
     * Used by Saferpay Gateway (max 33 chars?)
     *
     * @return string - max 30 characters long
     */
    public function getIdentifier()
    {

        if ($identifier = $this->auth0Id) {
            // Syntax: auth0|583eb8a0b43eff2344b967fb
            $identifier = str_replace('auth0|', '', $identifier);
        } else {
            // Replace special chars with "-"
            $identifier = 'anonym_' . preg_replace('/[^a-z0-9]/', '-', strtolower($this->getEmailAddress()));
        }

        return substr($identifier, 0, 30);
    }

    /**
     * Sets the Customer's Identifier
     *
     * @param string $auth0Id
     *
     * @return Customer
     */
    public function setIdentifier($auth0Id)
    {

        $this->auth0Id = $auth0Id;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuth0Id()
    {
        return $this->auth0Id;
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {

        return $this->emailAddress;
    }

    /**
     * Defines whether the user is registering an account or if it's an "anonymous" Order
     *
     * @return bool
     */
    public function isPersistent()
    {
        return $this->getAuth0Id() !== null;
    }

    /**
     * Returns whether the Customer is Anonymous
     *
     * @return bool
     */
    public function isAnonymous()
    {
        return !$this->isPersistent();
    }


    /**
     * @return string
     */
    public function getCustomerNumber()
    {
        return $this->customerNumber;
    }

    /**
     * @return boolean
     */
    public function isKlopotekCustomer()
    {
        return $this->klopotekCustomer;
    }


    /**
     * @return bool
     */
    public function hasCompleteRegistrationData()
    {
        return $this->billingAddress !== null;
    }

    function __toString()
    {
        return sprintf('Customer: email: "%s", has complete registration data: %d', $this->getEmailAddress(), $this->hasCompleteRegistrationData());
    }

}
