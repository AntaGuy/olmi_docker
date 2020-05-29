<?php

namespace App\Form\Resetting;

use App\DataTransferObject\ForgotPassword;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ForgotPasswordType
 * @package App\Form\Resetting
 */
class ForgotPasswordType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("email", EmailType::class, [
            "label" => "label.email",
            "attr" => [
                "placeholder" => "placeholder.email"
            ]
        ]);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("data_class", ForgotPassword::class);
    }
}
