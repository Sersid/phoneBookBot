<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Category\Domain\Exception;

use LogicException;

final class CategoryNotFoundException extends LogicException
{
    public function __construct()
    {
        parent::__construct('Категория не найдена', 404);
    }
}