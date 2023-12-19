<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\Domain\Entity;

use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\Shared\ValueObject\Uuid;

final class ContactBuilder
{
    private array $args = [];

    public function build(): Contact
    {
        /**
         * @psalm-suppress MixedArgument
         */
        return new Contact(...$this->args);
    }

    public function setUuid(Uuid $uuid): self
    {
        $this->args['uuid'] = clone $uuid;

        return $this;
    }

    public function setCategory(Category $category): self
    {
        $this->args['category'] = $category;

        return $this;
    }

    public function setName(Name $name): self
    {
        $this->args['name'] = clone $name;

        return $this;
    }

    public function setPhones(Phones $phones): self
    {
        $this->args['phones'] = $phones;

        return $this;
    }

    public function setAddress(Address $address): self
    {
        $this->args['address'] = $address;

        return $this;
    }

    public function setWebsite(Website $website): self
    {
        $this->args['website'] = $website;

        return $this;
    }
}