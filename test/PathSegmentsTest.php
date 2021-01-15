<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use function Biera\pathSegments;

class PathSegmentsTest extends TestCase
{
    /**
     * @test
     * @dataProvider pathSegmentsTestDataProvider
     */
    public function itGetsPathSegments(string $path, array $expectedPathSegments)
    {
        $this->assertEquals($expectedPathSegments, pathSegments($path));
    }

    /**
     * @return array
     */
    public function pathSegmentsTestDataProvider(): array
    {
        return [
            [
                '',
                []
            ],
            [
                '/',
                []
            ],
            [
                'high/way/to/hell',
                ['high', 'way', 'to', 'hell']
            ],
            [
                '/high/way/to/hell',
                ['high', 'way', 'to', 'hell']
            ],
            [
                'high/way/to/hell/',
                ['high', 'way', 'to', 'hell']
            ],
            [
                '/high/way/to/hell/',
                ['high', 'way', 'to', 'hell']
            ]
        ];
    }
}
