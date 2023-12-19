<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Category\Domain\Entity;

use Sersid\Shared\ValueObject\Uuid;

final class CategoryBuilder
{
    private array $args = [];

    public function build(): Category
    {
        /**
         * @psalm-suppress MixedArgument
         */
        return new Category(...$this->args);
    }

    public function setUuid(Uuid $uuid): self
    {
        $this->args['uuid'] = clone $uuid;

        return $this;
    }

    public function setName(Name $name): self
    {
        $this->args['name'] = clone $name;

        return $this;
    }

    public function setStatus(Status $status): self
    {
        $this->args['status'] = $status;

        return $this;
    }
}