<?php

/*
 * This file is part of the RollerworksDatagrid package.
 *
 * (c) Sebastiaan Stok <s.stok@rollerscapes.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Rollerworks\Component\Datagrid\Extension\Core\DataTransformer;

use Rollerworks\Component\Datagrid\Column\ColumnInterface;
use Rollerworks\Component\Datagrid\DataTransformerInterface;
use Rollerworks\Component\Datagrid\Exception\TransformationFailedException;

/**
 * CompoundColumnDataTransformer performs the transformers of the sub-columns.
 *
 * @author Sebastiaan Stok <s.stok@rollerscapes.net>
 */
class CompoundColumnTransformer implements DataTransformerInterface
{
    /**
     * @var array|ColumnInterface[]
     */
    private $columns = [];

    /**
     * Constructor.
     *
     * @param ColumnInterface[] $columns Sub-columns as field-name => ColumnInterface
     */
    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    public function transform($value)
    {
        $values = [];
        foreach ($this->columns as $name => $column) {
            $values[$name] = [];

            foreach ($column->getOption('field_mapping', []) as $field) {
                if (!array_key_exists($field, $value)) {
                    throw new TransformationFailedException(sprintf('Field "%s" is required by sub-column "%s" does not exist in head-parent column.', $field, $name));
                }

                $values[$name][$field] = $value[$field];
            }

            $values[$name] = $this->normToView($column, $values[$name]);
        }

        return $values;
    }

    /**
     * Transforms the value if a value transformer is set.
     *
     * @param ColumnInterface $column
     * @param mixed           $value  The value to transform
     *
     * @return mixed
     */
    private function normToView(ColumnInterface $column, $value)
    {
        // Scalar values should be converted to strings to
        // facilitate differentiation between empty ("") and zero (0).
        if (!$column->getViewTransformers()) {
            return null === $value || is_scalar($value) ? (string) $value : $value;
        }

        foreach ($column->getViewTransformers() as $transformer) {
            $value = $transformer->transform($value);
        }

        return $value;
    }
}
