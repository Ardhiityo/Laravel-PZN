<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Data\Person;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\LazyCollection;

class CollectionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCeateCollection(): void
    {
        $collection = collect([1, 2, 3, 5, 4]);

        // Dengan assertEqualsCanonicalizing, tidak memperhatikan urutan
        self::assertEqualsCanonicalizing([1, 2, 3, 4, 5], $collection->all());
    }

    public function testForEach(): void
    {
        // 0 1 2 3 4 : index
        // 1 2 3 4 5 : index + increment
        // 1 2 3 4 5 : value
        $collection = collect([1, 2, 3, 4, 5]);
        foreach ($collection as $key => $value) {
            self::assertEquals($key + 1, $value);
        }
    }

    public function testCrud(): void
    {
        $collection = collect([]);
        $collection->push(1, 2, 3);
        self::assertEqualsCanonicalizing([1, 2, 3], $collection->all());

        $result = $collection->pop();
        self::assertEquals(3, $result);

        self::assertEqualsCanonicalizing([1, 2], $collection->all());
    }

    public function testMap(): void
    {
        $collection = collect([1, 2, 3]);
        $result = $collection->map(function ($item) {
            return $item * 2;
        });
        self::assertEqualsCanonicalizing([2, 4, 6], $result->all());
    }

    public function testMapInto(): void
    {
        $collection = collect(["Eko"]);
        $result = $collection->mapInto(Person::class);

        self::assertEquals([new Person("Eko")], $result->all());
    }

    public function testMapSpread(): void
    {
        $collection = collect([
            ["Eko", "Budi"],
            ["Joko", "Joko"]
        ]);

        $result = $collection->mapSpread(function ($firstName, $lastName) {
            $fullName = "$firstName $lastName";
            return new Person($fullName);
        });

        self::assertEquals([
            new Person("Eko Budi"),
            new Person("Joko Joko")
        ], $result->all());
    }

    public function testMapToGroups(): void
    {
        $collection = collect([
            [
                "name" => "Eko",
                "department" => "IT"
            ],
            [
                "name" => "Budi",
                "department" => "HR"
            ],
            [
                "name" => "Joko",
                "department" => "IT"
            ]
        ]);

        $result = $collection->mapToGroups(function ($person) {
            return [$person["department"] => $person["name"]];
        });

        self::assertEquals([
            "IT" => collect(["Eko", "Joko"]),
            "HR" => collect(["Budi"])
        ], $result->all());
    }

    public function testZip(): void
    {
        $collection1 = collect([1, 2, 3]);
        $collection2 = collect([4, 5, 6]);
        $result = $collection1->zip($collection2);

        self::assertEquals([
            collect([1, 4]),
            collect([2, 5]),
            collect([3, 6])
        ], $result->all());
    }

    public function testConcat(): void
    {
        $collection1 = collect([1, 2, 3]);
        $collection2 = collect([4, 5, 6]);
        $result = $collection1->concat($collection2);

        self::assertEquals([1, 2, 3, 4, 5, 6], $result->all());
    }

    public function testCombine(): void
    {
        $collection1 = collect(["name", "country"]);
        $collection2 = collect(["Eko", "Indonesia"]);

        $result = $collection1->combine($collection2);

        self::assertEquals([
            "name" => "Eko",
            "country" => "Indonesia"
        ], $result->all());
    }

    public function testCollapse()
    {
        $collection = collect([
            [1, 2],
            [3, 4],
            [5, 6],
        ]);

        $result = $collection->collapse();

        self::assertEquals([1, 2, 3, 4, 5, 6], $result->all());
    }

    public function testFlatMap()
    {
        $collection = collect([
            [
                "nama" => "Eko",
                "hobby" => ["Coding", "Gaming"],
            ],
            [
                "nama" => "Budi",
                "hobby" => ["Fishing", "Editing"],
            ]
        ]);

        $result = $collection->flatMap(function ($person) {
            return $person['hobby'];
        });

        self::assertEquals(["Coding", "Gaming", "Fishing", "Editing"], $result->all());
    }

    public function testStingRepresentation()
    {
        $collection = collect(["Eko", "Kurniawan", "Khannedy"]);

        self::assertEquals("Eko-Kurniawan-Khannedy", $collection->join("-"));
        self::assertEquals("Eko, Kurniawan and Khannedy", $collection->join(", ", " and "));
    }

    public function testFilter()
    {
        $collection = collect([
            "eko" => 85,
            "budi" => 85,
            "joko" => 75
        ]);

        $result = $collection->filter(function ($item, $key) {
            return $item > 80;
        });

        self::assertEquals([
            "eko" => 85,
            "budi" => 85
        ], $result->all());
    }

    public function testFilterIndex()
    {
        $collection = collect([
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            10
        ]);

        $result = $collection->filter(function ($item, $key) {
            return $item % 2 == 0;
        });

        self::assertEqualsCanonicalizing([
            2,
            4,
            6,
            8,
            10
        ], $result->all());
    }

    public function testPartition()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        [$result1, $result2] = $collection->partition(function ($item, $key) {
            return $item % 2 == 0;
        });

        self::assertEqualsCanonicalizing([2, 4, 6, 8, 10], $result1->all());
    }

    public function testTesting()
    {
        $collection = collect(["Eko", "Kurrniawan", "Khannedy"]);

        $result1 = $collection->contains("Khannedy");
        self::assertTrue($result1);

        $result2 = $collection->contains(function ($item, $key) {
            return $item == "Eko";
        });
        self::assertTrue($result2);
    }

    public function testGroupBy()
    {

        $collection = collect([
            [
                "name" => "Eko",
                "department" => "IT"
            ],
            [
                "name" => "Budi",
                "department" => "IT"
            ],
            [
                "name" => "Joko",
                "department" => "HR"
            ],
        ]);

        $result1 = $collection->groupBy("department");

        self::assertEquals([
            "IT" => collect(
                [
                    [
                        "name" => "Eko",
                        "department" => "IT"
                    ],
                    [
                        "name" => "Budi",
                        "department" => "IT"
                    ],
                ]
            ),
            "HR" => collect([
                [
                    "name" => "Joko",
                    "department" => "HR"
                ]
            ]),

        ], $result1->all());

        $result2 = $collection->groupBy(function ($item, $key) {
            return $item["department"];
        });

        self::assertEquals(
            [
                "IT" => collect([
                    [
                        "name" => "Eko",
                        "department" => "IT",
                    ],
                    [
                        "name" => "Budi",
                        "department" => "IT"
                    ],
                ]),
                "HR" => collect([
                    [
                        "name" => "Joko",
                        "department" => "HR"
                    ]
                ])
            ],
            $result2->all()
        );
    }

    public function testSlice()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        $result = $collection->slice(4);
        self::assertEqualsCanonicalizing([5, 6, 7, 8, 9, 10], $result->all());

        $result2 = $collection->slice(4, 3);
        self::assertEqualsCanonicalizing([5, 6, 7], $result2->all());
    }

    public function testTake()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
        $result = $collection->take(3);
        self::assertEquals([1, 2, 3,], $result->all());

        $result = $collection->takeUntil(function ($item, $key) {
            return $item == 3;
        });
        self::assertEquals([1, 2], $result->all());

        $result = $collection->takeWhile(function ($item, $key) {
            return $item < 3;
        });
        self::assertEquals([1, 2], $result->all());
    }

    public function testSkip()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
        $result = $collection->skip(3);
        self::assertEqualsCanonicalizing([4, 5, 6, 7, 8, 9], $result->all());

        $result = $collection->skipUntil(function ($item, $key) {
            return $item == 3;
        });
        self::assertEqualsCanonicalizing([3, 4, 5, 6, 7, 8, 9], $result->all());

        $result = $collection->skipWhile(function ($item, $key) {
            return $item < 3;
        });
        self::assertEqualsCanonicalizing([3, 4, 5, 6, 7, 8, 9], $result->all());
    }

    public function testChunk()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
        $result = $collection->chunk(3);
        self::assertEqualsCanonicalizing([1, 2, 3], $result[0]->all());
        self::assertEqualsCanonicalizing([4, 5, 6], $result[1]->all());
        self::assertEqualsCanonicalizing([7, 8, 9], $result[2]->all());
        self::assertEqualsCanonicalizing([10], $result[3]->all());
    }

    public function testFirst()
    {
        $collection = collect([1, 2, 3, 4, 5]);
        $result = $collection->first();
        self::assertEquals(1, $result);

        $result = $collection->first(function ($item, $key) {
            return $item > 3;
        });
        self::assertEquals(4, $result);
    }

    public function testLast()
    {
        $collection = collect([1, 2, 3, 4, 5]);
        $result = $collection->last();
        self::assertEquals(5, $result);

        $result = $collection->last(function ($item, $key) {
            return $item < 3;
        });
        self::assertEquals(2, $result);
    }

    public function testRandom()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
        $result = $collection->random();
        self::assertTrue(in_array($result, [1, 2, 3, 4, 5, 6, 7, 8, 9]));

        // $result = $collection->random(5);
        // self::assertEqualsCanonicalizing([1, 2, 3, 4, 5], $result->all());
    }

    public function testCheckingExistance()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);

        self::assertFalse($collection->isEmpty());

        self::assertTrue($collection->isNotEmpty());

        self::assertTrue($collection->contains(1));

        self::assertTrue($collection->contains(function ($item, $key) {
            return $item == 8;
        }));
    }

    public function testOrder()
    {
        $collection = collect([3, 2, 1, 4, 5]);
        self::assertEqualsCanonicalizing([1, 2, 3, 4, 5], $collection->sort()->all());

        $collection = collect([3, 2, 1, 4, 5]);
        self::assertEqualsCanonicalizing([5, 4, 3, 2, 1], $collection->sortDesc()->all());
    }

    public function testAggregate()
    {
        $collection = collect([1, 2, 3, 4, 5]);
        self::assertEquals(1, $collection->min());
        self::assertEquals(5, $collection->max());
        self::assertEquals(3, $collection->avg());
        self::assertEquals(15, $collection->sum());
        self::assertEquals(5, $collection->count());
    }

    public function testReduce()
    {
        $collection = collect([1, 2, 3, 4, 5]);

        $result = $collection->reduce(function ($carry, $item) {
            return $carry + $item;
        });

        self::assertEquals(15, $result);
    }

    public function testLazyCollection()
    {
        $collection = LazyCollection::make(function () {
            $value = 0;
            while (true) {
                yield $value;
                $value++;
            }
        });

        $result = $collection->take(10);

        self::assertEquals([0, 1, 2, 3, 4, 5, 6, 7, 8, 9], $result->all());
    }
}
