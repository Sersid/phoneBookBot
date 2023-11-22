<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\UseCase;

use Sersid\ContactBookBot\Contact\Domain\Entity\Contact;
use Sersid\ContactBookBot\Contact\Domain\Entity\ContactRepositoryInterface;
use Sersid\Shared\ValueObject\Uuid;

final readonly class GetByUuid
{
    public function __construct(private ContactRepositoryInterface $repository)
    {
    }

    public function handle(string $uuid): Contact
    {
        return $this->repository->getByUuid(new Uuid($uuid));
    }
}