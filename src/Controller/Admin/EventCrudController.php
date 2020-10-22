<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use Cloudinary\Uploader as CloudinaryUploader;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Speicher210\CloudinaryBundle\Cloudinary\Cloudinary;
use Speicher210\CloudinaryBundle\Cloudinary\Uploader;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EventCrudController extends AbstractCrudController
{
    private $cloudinary;
    private $cloudinaryUploader;
    public function __construct()
    {
        // $this->cloudinaryUploader = $uploader;
        // $this->cloudinaryUploader = $this->get('speicher210_cloudinary.uploader');
    }
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // before saving the filename, the uploaded file should be uploaded to cloudinary
        // the public id of that file will be stored in the database as imageFilename
        // $uploader = $this->container->get('speicher210_cloudinary.uploader');
        $uploadedFile = \Cloudinary\Uploader::unsigned_upload($entityInstance->getImageFile(),'xt0x0u4t',[
            'cloud_name' => 'hwnrajpbq',
            // 'folder'=>'events'
        ]);
        // $uploadedFile = \Cloudinary::api_sign_request()
        $entityInstance
            ->setImageFilename($uploadedFile['public_id'])
            ->setImageFile(null)
        ;
        // var_dump($uploadedFile, $entityInstance->getImageFilename()); exit;
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // $uploader = $this->get('speicher210_cloudinary.uploader');
        // var_dump($entityInstance->getImageFile()); exit;

        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');
        $title = TextField::new('title');
        $description = TextEditorField::new('description');
        $venue = TextField::new('venue');
        $start = DateField::new('start');
        $end = DateField::new('end');
        $publish = BooleanField::new('publish');
        $category = AssociationField::new('category');
        $eventDates = AssociationField::new('eventDates');
        $association = AssociationField::new('association');
        // $imageFilename = ImageField::new('imageFilename')
        //     -> onlyOnIndex()
        //     ->setBasePath('uploads/images/events')
        // ;
        $imageFile = ImageField::new('imageFile')
            ->onlyOnForms()
            ->setFormType(VichImageType::class)
        ;

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $title, $venue, $start, $end, $association];
        } else if (Crud::PAGE_NEW === $pageName || Crud::PAGE_EDIT === $pageName) {
            return [$imageFile, $title, $description, $venue, $start, $end, $publish, $category, $eventDates, $association];
        }
    }
}
