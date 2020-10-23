<?php

namespace App\Controller\Admin;

use App\Entity\Appuser;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppuserCrudController extends AbstractCrudController
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoderInterface)
    {
        $this->passwordEncoder = $userPasswordEncoderInterface;
    }

    public static function getEntityFqcn(): string
    {
        return Appuser::class;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $plainPassword = $entityInstance->getPassword();
        $hashedPassword = $this->passwordEncoder->encodePassword($entityInstance, $plainPassword);
        $entityInstance->setPassword($hashedPassword);
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $plainPassword = $entityInstance->getPassword();
        $hashedPassword = $this->passwordEncoder->encodePassword($entityInstance, $plainPassword);
        $entityInstance->setPassword($hashedPassword);
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');
        $email = EmailField::new('email');
        $roles = ArrayField::new('roles');
        $password = TextField::new('password')
            ->setFormType(PasswordType::class)
        ;

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $email, $roles];
        } else {
            return [$email, $roles, $password];
        }
    }
}
