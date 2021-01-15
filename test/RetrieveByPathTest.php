<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use function Biera\retrieveByPath;

class RetrieveByPathTest extends TestCase
{
    /**
     * @test
     * @covers \Biera\retrieveByPath
     * @dataProvider retrieveByPathTestDataProvider
     */
    public function itRetrievesByPath($graph, array $path, $expectedResult)
    {
        $this->assertEquals($expectedResult, retrieveByPath($graph, $path));
    }

    /**
     * @test
     * @covers \Biera\retrieveByPath
     */
    public function itFailsToRetrieveByPathWhenInvalidPathProvided()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Path "high -> way -> to -> heaven" does not exist');

        retrieveByPath(
            [
                'high' =>
                    [
                        'way' => [
                            'to' => 'hell'
                        ]
                    ]
            ],
            ['high', 'way', 'to', 'heaven']
        );
    }

    /**
     * @test
     * @covers \Biera\retrieveByPath
     */
    public function itFailsToRetrieveByPathWhenInvalidGraphProvided()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Parameter "graph" must be of array|\ArrayAccess type');

        retrieveByPath(
            'not a graph', ['high', 'way', 'to', 'heaven']
        );
    }

    /**
     * @return array
     */
    public function retrieveByPathTestDataProvider(): array
    {
        return [
            [
                [],
                [],
                []
            ],
            [
                [
                    'owner' => [
                        'name' => 'Jakub',
                        'address' => [
                            'city' => 'Cracow',
                            'street' => 'Zabłocie 43A',
                            'code' => '30-701'
                        ]
                    ]
                ],
                ['owner'],
                [
                    'name' => 'Jakub',
                    'address' => [
                        'city' => 'Cracow',
                        'street' => 'Zabłocie 43A',
                        'code' => '30-701'
                    ]
                ]
            ],
            [
                [
                    'owner' => [
                        'name' => 'Jakub',
                        'address' => [
                            'city' => 'Cracow',
                            'street' => 'Zabłocie 43A',
                            'code' => '30-701'
                        ]
                    ]
                ],
                ['owner', 'address', 'city'],
                'Cracow'
            ]
        ];
    }
}


