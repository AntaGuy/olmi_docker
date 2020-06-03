<?php

namespace App\Form;

use App\Entity\Media;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('alt')
            ->add('image_file', VichImageType::class, [
                'required' => true,
                'allow_delete' => false,
                'asset_helper' => true,
                'image_uri' => true,
                'imagine_pattern' => 'thumb_widen'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
            'label' => false
        ]);
    }
}
