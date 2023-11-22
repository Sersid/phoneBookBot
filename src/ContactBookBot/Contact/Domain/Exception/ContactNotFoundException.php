<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\Domain\Exception;

use LogicException;

final class ContactNotFoundException extends LogicException
{
    public function __construct()
    {
        parent::__construct('Контакт не найден', 404);
    }
}