<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\Domain\Entity;

use Sersid\ContactBookBot\Contact\Domain\Exception\ContactNotFoundException;
use Sersid\Shared\ValueObject\Uuid;

interface ContactRepositoryInterface
{
    public function add(Contact $contact): void;

    public function update(Contact $contact): void;

    /**
     * @throws ContactNotFoundException
     */
    public function getByUuid(Uuid $uuid): Contact;
}