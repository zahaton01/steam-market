<?php

namespace App\Application\Tools\DecisionMaker\Decision;


/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
interface DecisionInterface
{
    /**
     * Sets the overall result of decision maker (true/false)
     *
     * @param bool $status
     *
     * @return DecisionInterface
     */
    public function setStatus(bool $status);

    /**
     * Returns extra data of the decision
     *
     * @return DecisionResultInterface
     */
    public function getResult();

    /**
     * Was the item declined for buying
     *
     * @return bool
     */
    public function isDeclined(): bool;

    /**
     * Was the item approved for buying
     *
     * @return bool
     */
    public function isApproved(): bool;
}