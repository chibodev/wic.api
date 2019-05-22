<?php

declare(strict_types=1);

namespace tests\Recipe\Unit\Formatter;

use App\Recipe\Formatter\RemovePredefinedWords;
use PHPUnit\Framework\TestCase;

class RemovePredefinedWordsTest extends TestCase
{
    /** @var RemovePredefinedWords */
    private $subject;

    public function setUp()
    {
        parent::setUp();

        $this->subject = new RemovePredefinedWords();
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
            ['yam and is beans and is oil', 'yam beans oil'],
            ['and is i am nice and but and not lovely', 'i am nice but not lovely'],
            ['it is right', 'it right']
        ];
    }
}
