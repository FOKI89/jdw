<?php
namespace AppBundle\Form\Type;

use AppBundle\Form\DataTransformer\AjaxSelectTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjaxSelect extends \Symfony\Component\Form\AbstractType
{
    public function getParent()
    {
        return ChoiceType::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->resetViewTransformers();
        if (!isset($options['parameters'])) {
            $options['paramaters'] = array();
        }
        $transformer = new AjaxSelectTransformer($options['repository'], $options['parameters']);
        $builder->addViewTransformer($transformer, true);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('repository');
        $resolver->setRequired('ajax_path');
        $resolver->setDefined('parameters');
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['ajax_path'] =  $options['ajax_path'];
    }
}