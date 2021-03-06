<?php
namespace Doctrine\MongoDB\Tests\Query;

use Doctrine\MongoDB\Query\Query;
use Doctrine\MongoDB\Tests\Constraint\ArrayHasValueUnderKey;

class QueryTest extends \PHPUnit_Framework_TestCase
{
    public function testMapReduceOptionsArePassed()
    {
        $collection = $this->getMockCollection();

        $queryArray = array(
            'type' => Query::TYPE_MAP_REDUCE,
            'mapReduce' => array(
                'map'     => '',
                'reduce'  => '',
                'options' => array('limit' => 10),
            ),
            'query' => array()
        );

        $query = new Query(
            $this->getMockDatabase(),
            $collection,
            $queryArray,
            array(),
            ''
        );

        $collection->expects($this->any())
                   ->method('mapReduce')
                   ->with($this->anything(),
                          $this->anything(),
                          $this->anything(),
                          $this->anything(),
                          new ArrayHasValueUnderKey('limit', 10)
                   );

        $query->execute();
    }

    public function testGeoNearOptionsArePassed()
    {
        $collection = $this->getMockCollection();

        $queryArray = array(
            'type' => Query::TYPE_GEO_LOCATION,
            'geoNear' => array(
                'near' => array(50, 50),
                'distanceMultiplier' => 2.5,
                'maxDistance' => 5,
                'spherical' => true,
            ),
            'limit' => 10,
            'query' => array('altitude' => array('$gt' => 1)),
        );

        $query = new Query(
            $this->getMockDatabase(),
            $collection,
            $queryArray,
            array(),
            ''
        );

        $collection->expects($this->any())
                   ->method('geoNear')
                   ->with(array(50, 50),
                          array('altitude' => array('$gt' => 1)),
                          $this->logicalAnd(
                              new ArrayHasValueUnderKey('distanceMultiplier', 2.5),
                              new ArrayHasValueUnderKey('maxDistance', 5),
                              new ArrayHasValueUnderKey('spherical', true),
                              new ArrayHasValueUnderKey('num', 10)
                          )
                   );

        $query->execute();
    }

    public function testEagerCursorPreparation()
    {
        $cursor = $this->getMockCursor();
        $collection = $this->getMockCollection();

        $collection->expects($this->once())
            ->method('find')
            ->with(array('foo' => 'bar'))
            ->will($this->returnValue($cursor));

        $queryArray = array(
            'type' => Query::TYPE_FIND,
            'query' => array('foo' => 'bar'),
            'select' => array(),
            'eagerCursor' => true,
            'hints' => array(),
            'immortal' => false,
            'limit' => null,
            'slaveOkay' => null,
            'skip' => null,
            'snapshot' => false,
            'sort' => array(),
        );

        $query = new Query($this->getMockDatabase(), $collection, $queryArray, array(), '');

        $eagerCursor = $query->execute();

        $this->assertInstanceOf('Doctrine\MongoDB\EagerCursor', $eagerCursor);
        $this->assertSame($cursor, $eagerCursor->getCursor());
    }

    /**
     * @return \Doctrine\MongoDB\Collection
     */
    private function getMockCollection()
    {
        return $this->getMockBuilder('Doctrine\MongoDB\Collection')
                    ->disableOriginalConstructor()
                    ->getMock();
    }

    /**
     * @return \Doctrine\MongoDB\Database
     */
    private function getMockDatabase()
    {
        return $this->getMockBuilder('Doctrine\MongoDB\Database')
                    ->disableOriginalConstructor()
                    ->getMock();
    }

    /**
     * @return \Doctrine\MongoDB\Cursor
     */
    private function getMockCursor()
    {
        return $this->getMockBuilder('Doctrine\MongoDB\Cursor')
            ->disableOriginalConstructor()
            ->getMock();
    }
}
