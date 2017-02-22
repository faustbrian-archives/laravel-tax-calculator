<?php

/*
 * This file is part of Laravel Tax Calculator.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

/*
 * This file is part of Laravel Tax Calculator.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\TaxCalculator;

class Calculator
{
    /**
     * @var int
     */
    private $amount;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var float
     */
    private $taxRate;

    /**
     * @var float
     */
    private $discount = 0;

    /**
     * @param string $currency
     * @param string $locale
     * @param int    $taxRate
     */
    public function __construct(string $currency, string $locale, float $taxRate)
    {
        $this->setCurrency($currency);
        $this->setLocale($locale);
        $this->setTaxRate($taxRate);
    }

    /**
     * @param int $value
     *
     * @return \BrianFaust\TaxCalculator\Calculator
     */
    public function setAmount(int $value): self
    {
        $this->amount = $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): integer
    {
        return $this->amount;
    }

    /**
     * @param float $value
     *
     * @return \BrianFaust\TaxCalculator\Calculator
     */
    public function setTaxRate(float $value): self
    {
        $this->taxRate = $value;

        return $this;
    }

    /**
     * @return float
     */
    public function getTaxRate(): float
    {
        return $this->taxRate;
    }

    /**
     * @param string $value
     *
     * @return \BrianFaust\TaxCalculator\Calculator
     */
    public function setCurrency(string $value): self
    {
        $this->currency = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $value
     *
     * @return \BrianFaust\TaxCalculator\Calculator
     */
    public function setLocale(string $value): self
    {
        $this->locale = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param float $value
     *
     * @return \BrianFaust\TaxCalculator\Calculator
     */
    public function setDiscount(float $value): self
    {
        $this->discount = $value / 100;

        return $this;
    }

    /**
     * @return float
     */
    public function getDiscount(): float
    {
        return $this->discount;
    }

    /**
     * @return \BrianFaust\TaxCalculator\Money
     */
    public function subtotal(): Money
    {
        return $this->toMoney($this->amount);
    }

    /**
     * @return \BrianFaust\TaxCalculator\Money
     */
    public function discount(): Money
    {
        $amount = $this->subtotal()->getAmount() * $this->discount;

        return $this->toMoney($amount);
    }

    /**
     * @return float
     */
    public function taxRate(): float
    {
        return $this->taxRate;
    }

    /**
     * @return \BrianFaust\TaxCalculator\Money
     */
    public function taxValue(): Money
    {
        $amount = ($this->subtotal()->getAmount() - $this->discount()->getAmount()) * $this->taxRate();

        return $this->toMoney($amount);
    }

    /**
     * @return \BrianFaust\TaxCalculator\Money
     */
    public function total(): Money
    {
        $amount = ($this->subtotal()->getAmount() - $this->discount()->getAmount()) + $this->taxvalue()->getAmount();

        return $this->toMoney($amount);
    }

    /**
     * @param float  $amount
     * @param string $currency
     *
     * @return \Money\Money
     */
    private function toMoney(float $amount): Money
    {
        return new Money($amount, $this->currency, $this->locale);
    }
}
