<?php


namespace App\Form\Type;


use App\Entity\ListeImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ListeImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('liste_image', CollectionType::class, [
            'entry_type' => ImageType::class,
            'entry_options' => ['label' => false]
        ]);

        $builder->add('upload', FileType::class, [
            'label' => 'Uploader une image (jpg)',

            // unmapped means that this field is not associated to any entity property
            'mapped' => false,

            'required' => false,

            // unmapped fields can't define their validation using annotations
            // in the associated entity, so you can use the PHP constraint classes
            'constraints' => [
                new File([
                    'maxSize' => '2m',
                    'mimeTypes' => [
                        'image/jpeg'
                    ],
                    'mimeTypesMessage' => 'Please upload a valid JPG image',
                ])
            ],
        ]);

        $builder->add( 'ajouter', SubmitType::class );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ListeImage::class,
        ]);
    }
}