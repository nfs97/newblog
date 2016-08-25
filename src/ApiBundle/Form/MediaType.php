<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 6/6/16
 * Time: 7:32 PM
 */

namespace ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('path', TextType::class, [
                'required'  => true,
            ])
            ->add('imageName', TextType::class, [
                'required'  => true,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'        => 'ApiBundle\Entity\Media',
            'csrf_protection'   => false,
            'allow_extra_fields' => true
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Media';
    }
}
