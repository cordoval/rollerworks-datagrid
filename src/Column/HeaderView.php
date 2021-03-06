<?php

/*
 * This file is part of the RollerworksDatagrid package.
 *
 * (c) Sebastiaan Stok <s.stok@rollerscapes.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Rollerworks\Component\Datagrid\Column;

use Rollerworks\Component\Datagrid\DatagridViewInterface;

/**
 * @author Sebastiaan Stok <s.stok@rollerscapes.net>
 */
class HeaderView
{
    /**
     * @var string
     */
    public $label;

    /**
     * @var ColumnInterface
     */
    public $column;

    /**
     * @var array
     */
    public $attributes = [];

    /**
     * @var DatagridViewInterface
     */
    public $datagrid;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $type;

    /**
     * @param ColumnInterface       $column
     * @param DatagridViewInterface $datagrid
     * @param string                $label
     */
    public function __construct(ColumnInterface $column, DatagridViewInterface $datagrid, $label)
    {
        $this->column = $column;
        $this->datagrid = $datagrid;
        $this->label = $label;

        $this->type = $column->getType()->getName();
        $this->name = $column->getName();
    }

    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }
}
