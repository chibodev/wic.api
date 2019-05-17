<?php

declare(strict_types=1);

namespace tests\Recipe\Tests\Unit\Formatter;

use App\Recipe\Formatter\RemoveSpecialCharAndWhitespaces;
use PHPUnit\Framework\TestCase;

class RemoveSpecialCharAndWhitespacesTest extends TestCase
{
    /** @var RemoveSpecialCharAndWhitespaces */
    private $subject;

    public function setUp()
    {
        parent::setUp();

        $this->subject = new RemoveSpecialCharAndWhitespaces();
    }

    /**
     * @dataProvider formatter
     */
    public function testApply(string $searchCriteria, string $formattedSearchCriteria)
    {
        self::assertSame($formattedSearchCriteria, $this->subject->apply($searchCriteria));
    }

    public function formatter(): array
    {
        return [
            ['i am right 1 am 1 i not 1', 'i am right  am  i not '],
            ['this $string h@as spéecia1l c_har', 'this string has special char'],
        ];
    }
}
