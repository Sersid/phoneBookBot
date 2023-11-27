<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\Domain\Entity;

use PHPUnit\Framework\TestCase;
use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Entity\Name as CategoryName;
use Sersid\ContactBookBot\Contact\Domain\Entity\Address;
use Sersid\ContactBookBot\Contact\Domain\Entity\Contact;
use Sersid\ContactBookBot\Contact\Domain\Entity\Name;
use Sersid\ContactBookBot\Contact\Domain\Entity\Phones;
use Sersid\ContactBookBot\Contact\Domain\Entity\Website;
use Sersid\Shared\ValueObject\Uuid;

abstract class ContactTestCase extends TestCase
{
    protected static Uuid $uuid;
    protected static Category $category;
    protected static Name $name;
    protected static Phones $phones;
    protected static Address $address;
    protected static Website $website;
    protected static Contact $contact;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$uuid = Uuid::next();
        self::$category = new Category(
            new Uuid('f3190be0-ecd2-4cd0-bf09-9d999bd17620'),
            new CategoryName('Управляющая компания')
        );
        self::$name = new Name('Диспетчер');
        self::$phones = new Phones();
        self::$address = new Address();
        self::$website = new Website();

        self::$contact = new Contact(
            uuid: self::$uuid,
            category: self::$category,
            name: self::$name,
            phones: self::$phones,
            address: self::$address,
            website: self::$website,
        );
    }
}