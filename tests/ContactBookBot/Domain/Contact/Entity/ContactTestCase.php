<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Domain\Contact\Entity;

use PHPUnit\Framework\TestCase;
use Sersid\ContactBookBot\Domain\Category\Entity\Category;
use Sersid\ContactBookBot\Domain\Category\Entity\Name as CategoryName;
use Sersid\ContactBookBot\Domain\Contact\Entity\Address;
use Sersid\ContactBookBot\Domain\Contact\Entity\Contact;
use Sersid\ContactBookBot\Domain\Contact\Entity\Name;
use Sersid\ContactBookBot\Domain\Contact\Entity\Phones;
use Sersid\ContactBookBot\Domain\Contact\Entity\Website;
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
        self::$name = new Name();
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