<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\Domain\Entity;

interface ContactRepositoryInterface
{
    public function add(Contact $contact): void;
}