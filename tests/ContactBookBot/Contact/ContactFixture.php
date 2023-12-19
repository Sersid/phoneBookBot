<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact;

use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Contact\Domain\Entity\Address;
use Sersid\ContactBookBot\Contact\Domain\Entity\Contact;
use Sersid\ContactBookBot\Contact\Domain\Entity\ContactBuilder;
use Sersid\ContactBookBot\Contact\Domain\Entity\Name;
use Sersid\ContactBookBot\Contact\Domain\Entity\Phones;
use Sersid\ContactBookBot\Contact\Domain\Entity\Website;
use Sersid\Shared\ValueObject\Uuid;
use Tests\ContactBookBot\Category\CategoryFixture;

final readonly class ContactFixture
{
    private ContactBuilder $contactBuilder;

    public function __construct()
    {
        $this->contactBuilder = (new ContactBuilder())
            ->setUuid(Uuid::next())
            ->setCategory((new CategoryFixture())->getDefault())
            ->setName(new Name('Название контакта'));
    }

    public function getDefault(): Contact
    {
        return $this->contactBuilder->build();
    }

    public function getWithCategory(Category $category): Contact
    {
        return $this->contactBuilder
            ->setCategory($category)
            ->build();
    }

    public function getWithName(Name $name): Contact
    {
        return $this->contactBuilder
            ->setName($name)
            ->build();
    }

    public function getWithPhones(Phones $phones): Contact
    {
        return $this->contactBuilder
            ->setPhones($phones)
            ->build();
    }

    public function getWithAddress(Address $address): Contact
    {
        return $this->contactBuilder
            ->setAddress($address)
            ->build();
    }

    public function getWithWebsite(Website $website): Contact
    {
        return $this->contactBuilder
            ->setWebsite($website)
            ->build();
    }
}