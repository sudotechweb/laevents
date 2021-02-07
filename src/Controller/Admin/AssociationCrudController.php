<?php

namespace App\Controller\Admin;

use App\Entity\Association;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AssociationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Association::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');
        $name = TextField::new('name');
        $email = EmailField::new('email');
        $phone = NumberField::new('phone');
        $description = TextEditorField::new('description');
        $events = AssociationField::new('events');
        $logoFileName = ImageField::new('logoFileName');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $events];
        } else {
            return [$name, $email, $phone, $description];
        }
    }
}
