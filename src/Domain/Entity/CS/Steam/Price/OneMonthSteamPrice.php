<?php

namespace App\Domain\Entity\CS\Steam\Price;

use App\Domain\Entity\CS\Steam\AbstractSteamPrice;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 *
 * @ORM\Table("cs_one_month_steam_prices")
 * @ORM\Entity(repositoryClass="App\Domain\Repository\CS\CSItemPriceRepository")
 */
class OneMonthSteamPrice extends AbstractSteamPrice
{

}