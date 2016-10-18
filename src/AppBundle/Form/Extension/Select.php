<?php
namespace AppBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Select extends AbstractTypeExtension
{
    public function getExtendedType()
    {
        return ChoiceType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'attr' => array(
                'class' => 'bootstrap-select'
            ),
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $options['attr']['class'] = isset($options['attr']['class']) ? $options['attr']['class'] : '';
        $options['attr']['class'] .= ' bootstrap-select';

        $view->vars = array_replace($view->vars, array(
            'attr' => $options['attr'],
        ));
    }
}