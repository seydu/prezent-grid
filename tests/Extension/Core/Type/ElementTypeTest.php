<?php

namespace Prezent\Grid\Tests\Extension\Core\Type;

use Prezent\Grid\Extension\Core\Type\ColumnType;
use Prezent\Grid\Extension\Core\Type\ElementType;
use Prezent\Grid\Extension\Core\Type\StringType;
use Prezent\Grid\Tests\Extension\Core\TypeTest;

class ElementTypeTest extends TypeTest
{
    public function testDefaultsFromName()
    {
        $grid = $this->gridFactory->createBuilder()
            ->addColumn('foo', ElementType::class)
            ->getGrid();

        $view = $grid->createView();

        $this->assertEquals('foo', $view->columns['foo']->vars['label']);
    }

    public function testEmptyLabel()
    {
        $grid = $this->gridFactory->createBuilder()
            ->addColumn('foo', ColumnType::class, ['label' => false])
            ->getGrid();

        $view = $grid->createView();

        $this->assertFalse($view->columns['foo']->vars['label']);
    }

    public function testBlockTypes()
    {
        $grid = $this->gridFactory->createBuilder()
            ->addColumn('foo', StringType::class)
            ->getGrid();

        $view = $grid->createView();

        $this->assertEquals(['string', 'column', 'element'], $view->columns['foo']->vars['block_types']);
    }

    public function testAttributeResolver()
    {
        $data = (object)['id' => 1, 'name' => 'foobar'];

        $grid = $this->gridFactory->createBuilder()
            ->addColumn('name', StringType::class, ['attr' => [
                'data-id' => '{id}'
            ]])
            ->getGrid();

        $view = $grid->createView();
        $view->columns['name']->bind($data);

        $this->assertEquals(['data-id' => '1'], $view->columns['name']->vars['attr']);
    }
}
