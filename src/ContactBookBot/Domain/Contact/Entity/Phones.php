<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Domain\Contact\Entity;

use LogicException;
use Ramsey\Collection\AbstractCollection;

/**
 * @extends AbstractCollection<Phone>
 */
final class Phones extends AbstractCollection
{
    public function getType(): string
    {
        return Phone::class;
    }

    public function addPhone(Phone $phone): void
    {
        $cleanNumber = $phone->getCleanNumber();
        foreach ($this as $existPhone) {
            if ($cleanNumber === $existPhone->getCleanNumber()) {
                throw new LogicException('Номер телефона уже существует');
            }
        }

        $this->add($phone);
    }
}