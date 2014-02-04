<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="account_type", type="string")
 * @ORM\DiscriminatorMap({
 *  "yandex_money" = "Application\Entity\User\Administrator",
 *  "qiwi_wallet" = "Application\Entity\User\Teacher"
 * })
 * @ORM\Table(name="z2t_monney_accounts")
 */
class MoneyAccount
{
    
}
