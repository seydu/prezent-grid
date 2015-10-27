<?php

namespace Prezent\Grid\Extension\Core\Type;

use Prezent\Grid\BaseElementTypeExtension;
use Prezent\Grid\ElementView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Allow truncating text
 *
 * @see BaseElementTypeExtension
 * @author Sander Marechal
 */
class TruncateTypeExtension extends BaseElementTypeExtension
{
    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults([
                'truncate'           => false,
                'truncate_word'      => false,
                'truncate_separator' => '...',
            ])
            ->setAllowedTypes([
                'truncate'           => ['bool', 'int'],
                'truncate_word'      => 'bool',
                'truncate_separator' => 'string',
            ])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function buildView(ElementView $view, array $options)
    {
        $view->vars['truncate'] = $options['truncate'];
        $view->vars['truncate_word'] = $options['truncate_word'];
        $view->vars['truncate_separator'] = $options['truncate_separator'];
    }

    /**
     * {@inheritDoc}
     */
    public function getExtendedType()
    {
        return 'string';
    }
}
