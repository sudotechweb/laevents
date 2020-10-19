<?php

namespace App\Controller\Admin;

use App\Entity\Appuser;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AppuserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Appuser::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');
        $email = EmailField::new('email');
        $roles = ArrayField::new('roles');
        $password = TextField::new('password');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $email, $roles];
        } else {
            return [$email, $roles, $password];
        }
    }
}
