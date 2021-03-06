<?php

/*
 * This file is part of the RollerworksDatagrid package.
 *
 * (c) Sebastiaan Stok <s.stok@rollerscapes.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Rollerworks\Component\Datagrid\Tests;

use Rollerworks\Component\Datagrid\DataRowset;
use Rollerworks\Component\Datagrid\Exception\UnexpectedTypeException;
use Rollerworks\Component\Datagrid\Tests\Fixtures\Entity;

class DataRowsetTest extends \PHPUnit_Framework_TestCase
{
    public function testCannotCreateWithInvalidData()
    {
        $this->setExpectedException(UnexpectedTypeException::class);

        new DataRowset('Invalid Data');
    }

    public function testCreateRowsetWithArray()
    {
        $data = [
            'e1' => new Entity('entity1'),
            'e2' => new Entity('entity2'),
        ];

        $rowset = new DataRowset($data);

        foreach ($rowset as $index => $row) {
            $this->assertSame($data[$index], $row);
        }

        $this->assertCount(2, $rowset);
    }
}
