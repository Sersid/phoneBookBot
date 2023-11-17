<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Domain\Contact\Entity;

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
}