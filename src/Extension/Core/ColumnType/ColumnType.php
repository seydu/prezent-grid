<?php

namespace Prezent\Grid\Extension\Core\ColumnType;

use Prezent\Grid\BaseColumnType;
use Prezent\Grid\ColumnView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * ColumnType
 *
 * @see ColumnType
 * @author Sander Marechal
 */
class ColumnType extends BaseColumnType
{
    /**
     * @var PropertyAccessor
     */
    private $accessor;

    /**
     * Constructor
     *
     * @param PropertyAccess $accessor
     */
    public function __construct(PropertyAccessorInterface $accessor)
    {
        $this->accessor = $accessor;
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'property_path' => null,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function buildView(ColumnView $view, array $options)
    {
        $view->vars['property_path'] = $options['property_path'] ?: $view->name;
    }

    /**
     * {@inheritDoc}
     */
    public function getValue(ColumnView $view, $item, $value)
    {
        return $this->accessor->getValue($item, $view->vars['property_path']);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'column';
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'element';
    }
}
