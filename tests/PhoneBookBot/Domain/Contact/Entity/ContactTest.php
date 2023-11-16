<?php
declare(strict_types=1);

namespace Tests\PhoneBookBot\Domain\Contact\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Depends;
use Sersid\PhoneBookBot\Domain\Category\Entity\Category;
use Sersid\PhoneBookBot\Domain\Category\Entity\Name as CategoryName;
use Sersid\PhoneBookBot\Domain\Contact\Entity\Contact;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Sersid\PhoneBookBot\Domain\Contact\Entity\Website;
use Sersid\PhoneBookBot\Domain\Contact\Event;
use Sersid\PhoneBookBot\Domain\Contact\Entity\Name;
use Sersid\PhoneBookBot\Domain\Contact\Entity\Status;
use Sersid\Shared\ValueObject\Uuid;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotSame;
use function PHPUnit\Framework\assertSame;

#[CoversClass(Contact::class)]
#[TestDox('Тесты контакта')]
final class ContactTest extends TestCase
{
    private static Uuid $uuid;
    private static Category $category;
    private static Name $name;
    private static Website $website;
    private static Contact $contact;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$uuid = Uuid::next();
        self::$category = new Category(
            new Uuid('f3190be0-ecd2-4cd0-bf09-9d999bd17620'),
            new CategoryName('Управляющая компания')
        );
        self::$name = new Name('Паспортный стол');
        self::$website = new Website();

        self::$contact = new Contact(
            uuid: self::$uuid,
            category: self::$category,
            name: self::$name,
            website: self::$website,
        );
    }

    #[TestDox('Тест создания контакта')]
    public function testCreate(): void
    {
        assertSame(self::$uuid, self::$contact->getUuid());
        assertSame(self::$category, self::$contact->getCategory());
        assertSame(self::$name, self::$contact->getName());
        assertSame(Status::Enable, self::$contact->getStatus());
    }

    #[TestDox('Тест создания события при создании контакта')]
    #[Depends('testCreate')]
    public function testEventOnCreated(): void
    {
        /** @var Event\ContactCreatedEvent $event */
        $event = self::$contact->releaseEvents()[0];

        assertInstanceOf(Event\ContactCreatedEvent::class, $event);
        assertSame(self::$contact, $event->getContact());
    }

    #[TestDox('Тест попытки изменения категории на такую же категорию')]
    public function testNoChangeCategory(): void
    {
        $category = new Category(
            new Uuid('f3190be0-ecd2-4cd0-bf09-9d999bd17620'),
            new CategoryName('Управляющая компания')
        );

        self::$contact->changeCategory($category);

        assertNotSame(self::$contact->getCategory(), $category);
        assertSame([], self::$contact->releaseEvents());
    }

    #[TestDox('Тест изменения категории')]
    public function testChangeCategory(): void
    {
        $category = new Category(Uuid::next(), new CategoryName('Новая категория'));

        self::$contact->changeCategory($category);

        assertSame($category, self::$contact->getCategory());
    }

    #[TestDox('Тест создания события при изменении категории')]
    #[Depends('testChangeCategory')]
    public function testEventOnChangeCategory(): void
    {
        /** @var Event\ContactChangedCategoryEvent $event */
        $event = self::$contact->releaseEvents()[0];

        assertInstanceOf(Event\ContactChangedCategoryEvent::class, $event);
        assertSame(self::$contact, $event->getContact());
        assertSame(self::$category, $event->getOldCategory());
    }

    #[TestDox('Тест попытки переименовать контакт в то же имя')]
    public function testNoRename(): void
    {
        $newName = new Name('Паспортный стол');

        self::$contact->rename($newName);

        assertNotSame(self::$contact->getName(), $newName);
        assertSame([], self::$contact->releaseEvents());
    }

    #[TestDox('Тест переименования контакта')]
    public function testRename(): void
    {
        $newName = new Name('Новое имя контакта');

        self::$contact->rename($newName);

        assertSame(self::$contact->getName(), $newName);
    }

    #[TestDox('Тест создания события при переименовании контакта')]
    #[Depends('testRename')]
    public function testEventOnRename(): void
    {
        /** @var Event\ContactRenamedEvent $event */
        $event = self::$contact->releaseEvents()[0];

        assertInstanceOf(Event\ContactRenamedEvent::class, $event);
        assertSame(self::$contact, $event->getContact());
        assertSame(self::$name, $event->getOldName());
    }

    #[TestDox('Тест попытки изменить вебсайт на тот же')]
    public function testNoChangeWebsite(): void
    {
        $website = new Website();

        self::$contact->changeWebsite($website);

        assertNotSame(self::$contact->getWebsite(), $website);
        assertSame([], self::$contact->releaseEvents());
    }

    #[TestDox('Тест изменения вебсайта')]
    public function testChangeWebsite(): void
    {
        $website = new Website('www.website.com');

        self::$contact->changeWebsite($website);

        assertSame(self::$contact->getWebsite(), $website);
    }

    #[TestDox('Тест создания события при изменении вебсайта')]
    #[Depends('testChangeWebsite')]
    public function testEventOnChangeWebsite(): void
    {
        /** @var Event\ContactChangedWebsiteEvent $event */
        $event = self::$contact->releaseEvents()[0];

        assertInstanceOf(Event\ContactChangedWebsiteEvent::class, $event);
        assertSame(self::$contact, $event->getContact());
        assertSame(self::$website, $event->getOldWebsite());
    }
}
