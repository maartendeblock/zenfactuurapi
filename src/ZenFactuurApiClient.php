<?php

namespace MaartenDeBlock\ZenFactuurApi;

use MaartenDeBlock\ZenFactuurApi\Apis;

class ZenFactuurApiClient
{
  /**
   * @var Apis\ApiToken
   */
  public $ApiToken;
  /**
   * @var Apis\Bill
   */
  public $Bill;
  /**
   * @var Apis\BillingUnit
   */
  public $BillingUnit;
  /**
   * @var Apis\Country
   */
  public $Country;
  /**
   * @var Apis\CreditNote
   */
  public $CreditNote;
  /**
   * @var Apis\Customer
   */
  public $Customer;
  /**
   * @var Apis\IncomeCategories
   */
  public $IncomeCategories;
  /**
   * @var Apis\Invoice
   */
  public $Invoice;
  /**
   * @var Apis\InvoiceNumber
   */
  public $InvoiceNumber;
  /**
   * @var Apis\Payment
   */
  public $Payment;
  /**
   * @var Apis\Project
   */
  public $Project;
  /**
   * @var Apis\Purchase
   */
  public $Purchase;
  /**
   * @var Apis\Quotation
   */
  public $Quotation;
  /**
   * @var Apis\QuotationNumber
   */
  public $QuotationNumber;
  /**
   * @var Apis\SaleItem
   */
  public $SaleItem;
  /**
   * @var Apis\Sell
   */
  public $Sell;
  /**
   * @var Apis\StructuredCommunication
   */
  public $StructuredCommunication;
  /**
   * @var Apis\Supplier
   */
  public $Supplier;
  /**
   * @var Apis\TimeRegistration
   */
  public $TimeRegistration;
  /**
   * @var Apis\VatPercentage
   */
  public $VatPercentage;
  /**
   * @var Apis\WarehouseIntegration
   */
  public $WarehouseIntegration;

  public function __construct($api_token)
  {
    $this->ApiToken = new Apis\ApiToken($api_token);
    $this->Bill = new Apis\Bill($api_token);
    $this->BillingUnit = new Apis\BillingUnit($api_token);
    $this->Country = new Apis\Country($api_token);
    $this->CreditNote = new Apis\CreditNote($api_token);
    $this->Customer = new Apis\Customer($api_token);
    $this->IncomeCategories = new Apis\IncomeCategories($api_token);
    $this->Invoice = new Apis\Invoice($api_token);
    $this->InvoiceNumber = new Apis\InvoiceNumber($api_token);
    $this->Payment = new Apis\Payment($api_token);
    $this->Project = new Apis\Project($api_token);
    $this->Purchase = new Apis\Purchase($api_token);
    $this->Quotation = new Apis\Quotation($api_token);
    $this->QuotationNumber = new Apis\QuotationNumber($api_token);
    $this->SaleItem = new Apis\SaleItem($api_token);
    $this->Sell = new Apis\Sell($api_token);
    $this->StructuredCommunication = new Apis\StructuredCommunication($api_token);
    $this->Supplier = new Apis\Supplier($api_token);
    $this->TimeRegistration = new Apis\TimeRegistration($api_token);
    $this->VatPercentage = new Apis\VatPercentage($api_token);
    $this->WarehouseIntegration = new Apis\WarehouseIntegration($api_token);
  }
}