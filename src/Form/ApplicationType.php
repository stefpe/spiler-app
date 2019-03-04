<?php

namespace App\Form;

use App\Entity\Application;
use App\Entity\DisplayPreset;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ApplicationType
 * @package AppBundle\Form
 */
class ApplicationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('apiKey', TextType::class, [
                'attr' => [
                    'readonly' => true,
                    'placeholder' => 'API key will be generated'
                ]
            ])
            ->add(
                'displayPreset',
                EntityType::class,
                [
                    'class' => DisplayPreset::class,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('preset')
                            ->orderBy('preset.name', 'ASC');
                    },
                    'choice_label' => 'name'
                ]
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Application::class
        ]);
    }
}
