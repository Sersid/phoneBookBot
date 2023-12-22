<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\Domain\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Sersid\ContactBookBot\Contact\Domain\Entity\Address;
use Sersid\ContactBookBot\Contact\Domain\Entity\Contact;
use Sersid\ContactBookBot\Contact\Domain\Entity\MapLocation;
use Sersid\ContactBookBot\Contact\Domain\Entity\Name;
use Sersid\ContactBookBot\Contact\Domain\Entity\Phone;
use Sersid\ContactBookBot\Contact\Domain\Entity\Phones;
use Sersid\ContactBookBot\Contact\Domain\Entity\Status;
use Sersid\ContactBookBot\Contact\Domain\Entity\Website;
use Sersid\Shared\ValueObject\Uuid;
use Tests\ContactBookBot\Category\CategoryFixture;
use Tests\ContactBookBot\Contact\ContactFixture;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

#[CoversClass(Contact::class)]
#[TestDox('Тесты контакта')]
final class ContactTest extends TestCase
{
    protected CategoryFixture $categoryFixture;
    protected ContactFixture $contactFixture;

    protected function setUp(): void
    {
        parent::setUp();

        $this->categoryFixture = new CategoryFixture();
        $this->contactFixture = new ContactFixture();
    }

    #[TestDox('Тест создания контакта')]
    public function testCreate(): void
    {
        $uuid = Uuid::next();
        $category = $this->categoryFixture->getDefault();
        $name = new Name('Диспетчер');
        $phones = new Phones();
        $address = new Address();
        $website = new Website();

        $contact = new Contact(
            uuid: $uuid,
            category: $category,
            name: $name,
            phones: $phones,
            address: $address,
            website: $website,
        );

        assertSame($uuid, $contact->getUuid());
        assertSame($category, $contact->getCategory());
        assertSame($name, $contact->getName());
        assertSame(Status::Draft, $contact->getStatus());
    }

    #[TestDox('Тест попытки изменения категории на такую же категорию')]
    public function testNoChangeCategory(): void
    {
        $category = $this->categoryFixture->getDefault();
        $contact = $this->contactFixture->getWithCategory($category);

        $this->expectExceptionMessage('Категория не изменилась');

        $contact->changeCategory($category);
    }

    #[TestDox('Тест изменения категории')]
    public function testChangeCategory(): void
    {
        $category = $this->categoryFixture->getWithUuid(Uuid::next());
        $contact = $this->contactFixture->getDefault();

        $contact->changeCategory($category);

        assertSame($category, $contact->getCategory());
    }

    #[TestDox('Тест попытки переименовать контакт в то же имя')]
    public function testNoRename(): void
    {
        $name = new Name('Диспетчер');
        $contact = $this->contactFixture->getWithName($name);

        $this->expectExceptionMessage('Название контакта не изменилось');

        $contact->rename($name);
    }

    #[TestDox('Тест переименования контакта')]
    public function testRename(): void
    {
        $newName = new Name('Новое имя контакта');
        $contact = $this->contactFixture->getWithName(new Name('Диспетчер'));

        $contact->rename($newName);

        assertSame($contact->getName(), $newName);
    }

    #[TestDox('Тест удаления телефона')]
    public function testRemovePhone(): void
    {
        $phone = new Phone('88005553535', 'Диспетчер');
        $contact = $this->contactFixture->getWithPhones(new Phones([$phone]));

        $result = $contact->removePhone(0);

        assertTrue($contact->getPhones()->isEmpty());
        assertSame($phone, $result);
    }

    #[TestDox('Тест попытки удаления несуществующего телефона')]
    public function testRemoveUndefinedPhone(): void
    {
        $contact = $this->contactFixture->getDefault();

        $this->expectExceptionMessage('Телефон не найден');

        $contact->removePhone(100);
    }

    #[TestDox('Тест попытки изменить адрес без изменения содержимого адреса')]
    public function testNoChangeAddress(): void
    {
        $address = new Address('ул. Пушкина, 1');
        $contact = $this->contactFixture->getWithAddress($address);

        $this->expectExceptionMessage('Адрес контакта не изменился');

        $contact->changeAddress($address);
    }

    #[TestDox('Тест изменения адреса')]
    public function testChangeAddress(): void
    {
        $address = new Address('ул. Пушкина, 1');
        $contact = $this->contactFixture->getWithAddress(new Address());

        $contact->changeAddress($address);

        assertSame($contact->getAddress(), $address);
    }

    #[TestDox('Тест попытки изменить вебсайт на тот же')]
    public function testNoChangeWebsite(): void
    {
        $website = new Website('www.website.com');
        $contact = $this->contactFixture->getWithWebsite($website);

        $this->expectExceptionMessage('Вебсайта контакта не изменился');

        $contact->changeWebsite($website);
    }

    #[TestDox('Тест изменения вебсайта')]
    public function testChangeWebsite(): void
    {
        $website = new Website('www.website.com');
        $contact = $this->contactFixture->getWithWebsite(new Website());

        $contact->changeWebsite($website);

        assertSame($contact->getWebsite(), $website);
    }

    #[TestDox('Тест попытки повторной публикации контакта')]
    public function testPublishAgain(): void
    {
        $contact = $this->contactFixture->getPublished();

        $this->expectExceptionMessage('Контакт уже опубликован');

        $contact->publish();
    }

    #[TestDox('Тест попытки опубликовать контакт без контактных данных')]
    public function testPublishEmptyContact(): void
    {
        $contact = $this->contactFixture->getDefault();

        $this->expectExceptionMessage('Необходимо указать контактную информацию');

        $contact->publish();
    }

    public static function publishDataProvider(): array
    {
        return [
            'есть адрес' => [
                ['address' => new Address('ул. Пушкина, д. 1')]
            ],
            'есть координаты на карте' => [
                ['address' => new Address('', new MapLocation(51.6607, 39.2003))]
            ],
            'есть вебсайт' => [
                ['website' => new Website('www.example.com')]
            ],
            'есть телефон' => [
                ['phones' => new Phones([new Phone('88005553535')])]
            ],
        ];
    }

    #[TestDox('Тест публикации контакта')]
    #[DataProvider('publishDataProvider')]
    public function testPublish(array $arrange): void
    {
        $contact = $this->contactFixture->getWithArgs($arrange);

        $contact->publish();

        assertSame(Status::Published, $contact->getStatus());
    }

    #[TestDox('Тест повторного перемещения контакта в черновик')]
    public function testToDraftAgain(): void
    {
        $contact = $this->contactFixture->getDraft();

        $this->expectExceptionMessage('Контакт уже перемещен в черновики');

        $contact->toDraft();
    }

    #[TestDox('Тест снятия с публикации')]
    public function testUnpublished(): void
    {
        $contact = $this->contactFixture->getPublished();

        $contact->unpublish();

        assertSame(Status::Unpublished, $contact->getStatus());
    }

    #[TestDox('Тест повторного снятия с публикации')]
    public function testUnpublishedAgain(): void
    {
        $contact = $this->contactFixture->getUnpublished();

        $this->expectExceptionMessage('Контакт уже снят с публикации');

        $contact->unpublish();
    }

    #[TestDox('Тест перемещения контакта в черновик')]
    public function testToDraft(): void
    {
        $contact = $this->contactFixture->getPublished();

        $contact->toDraft();

        assertSame(Status::Draft, $contact->getStatus());
    }
}
