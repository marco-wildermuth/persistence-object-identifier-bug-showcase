<?php
namespace CRON\Test\Domain\Model;

/*                                                                        *
 * This script belongs to the Neos Flow package "CRON.DavShop".          *
 *                                                                        *
 *                                                                        */

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Utility\Algorithms;

/**
 * @Flow\Entity
 *
 * Order Class
 *
 * @package CRON\Test\Domain\Model
 *
 * @TODO create Interface for Order and Basket
 */
class Order implements \JsonSerializable
{

    /**
     * @var Customer
     * @Flow\IgnoreValidation
     * @ORM\Column(type="object", nullable=false)
     */
    protected $user;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetimetz", nullable=false)
     */
    protected $created;

    /**
     * @var Address
     * @ORM\Column(type="object", nullable=true)
     */
    protected $billingAddress;

    /**
     * @var Address
     * @ORM\Column(type="object", nullable=true)
     */
    protected $deliveryAddress;

    /**
     * @var string
     */
    protected $paymentMethod;

    /**
     * @var array
     */
    protected $paymentData = [];

    /**
     * @var integer
     * @ORM\Column(type="string", nullable=true)
     */
    protected $status;

    /**
     * @var OrderProduct[]
     * @ORM\Column(type="object", nullable=true)
     */
    protected $products;

    /**
     * @var float
     */
    protected $shipping;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $voucher;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $customerComment;

    /**
     * UUID of this order, generated on each creation
     *
     * @var string
     */
    protected $identifier;

    /**
     * Note: the id is created after the order was created, prior to that it will be null
     *
     * @ORM\Column(type="integer", nullable=true)
     * @ORM\GeneratedValue
     *
     * @var integer
     */
    protected $id;

    /**
     * Order constructor
     */
    public function __construct()
    {

        $this->created = new \DateTime('now');
        $this->setStatus(0);
        $this->identifier = Algorithms::generateUUID();
    }

    /**
     * Defines which data will be given over to json_encode
     *
     * @return array
     */
    public function jsonSerialize()
    {

        return [
            'orderID' => $this->getOrderID(),
            'products' => $this->getProducts(),
            'totals' => 0
        ];
    }

    /**
     * Returns the Order's ID
     *
     * @return string - max 33 characters long
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }


    /**
     * Returns the id generated as primary key in the DB, if any
     *
     * @return integer|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Customer
     *
     */
    public function getCustomer()
    {

        return $this->user;
    }


    /**
     * @return int
     */
    public function getStatus()
    {

        return $this->status;
    }

    /**
     * @param int $status
     *
     * @return Order
     */
    public function setStatus($status)
    {

        $this->status = $status;

        return $this;
    }

    /**
     * Returns the Order's Products
     *
     * @return OrderProduct[]|Collection<OrderProduct>
     */
    public function getProducts()
    {

        return $this->products;
    }


    /**
     * Gets the Order Identifier (Bestellnummer)
     *
     * Format xxxxx-<Customer Number>
     *
     * <CustomerNumber>: "Klopotek Kundennummer"
     * Note: for "anonymous" or "not verified" Customers, the string "0000" should be used instead
     *
     * @return string
     */
    public function getOrderID()
    {
        $customerNumber = "0000"; // fallback

        if ($customer = $this->getCustomer()) {
            if (!$customer->isAnonymous() && $customer->isKlopotekCustomer()) {
                $customerNumber = $customer->getCustomerNumber();
            }
        }

        $sequenceNumber = strval($this->id);

        $orderID = implode("-", [
            $sequenceNumber,
            $customerNumber,
        ]);

        return $orderID;
    }

}
