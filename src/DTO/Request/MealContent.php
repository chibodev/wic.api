<?php

declare(strict_types=1);

namespace App\DTO\Request;

class MealContent
{
    /** @var string */
    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
