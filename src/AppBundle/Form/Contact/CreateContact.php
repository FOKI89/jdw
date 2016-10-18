<?php
namespace AppBundle\Form\Contact;

use AppBundle\Enum\Gender;
use AppBundle\Form\Type\AjaxSelect;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateContact extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'firstname'
            ])
            ->add('lastName', TextType::class)
            ->add('gender', ChoiceType::class, [
                'choices' => Gender::getChoices()
            ])
            ->add('address', TextType::class, [
                'required' => false,
            ])
            ->add('postal_code', TextType::class, [
                'required' => false
            ])
            ->add('titleId', AjaxSelect::class, [
                'repository' => $options['title_repository'],
                'ajax_path' => '_getTitles',
                'label' => 'title',
                'attr' => array('data-live-search' => true),
                'parameters' => array('userId' => $options['userId'])
            ])
            ->add('addTitleButton', ButtonType::class, [
                'attr' => array(
                    'data-target' => '#myModal',
                    'data-toggle' => 'modal'
                ),
                'label' => '+'
            ])
            ->add('country', CountryType::class, [
                'label' => 'country',
                'attr' => array('data-live-search' => true)
            ])
            ->add('save', SubmitType::class, array('label' => 'Add contact'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(array('title_repository', 'userId'));
        $resolver->setDefaults(array(
            'csrf_protection' => false
        ));
    }


}