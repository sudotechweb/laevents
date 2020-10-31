<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Entity\EventDates;
use App\Form\EventDateTimeType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
        if ($entityInstance->getCategory()) {
            $catName = strtolower(str_replace('&','-',str_replace(' ','-',$entityInstance->getCategory()->getName())));
            $uploadedFile = \Cloudinary\Uploader::unsigned_upload($entityInstance->getImageFile(),'xt0x0u4t',[
                'cloud_name' => 'hwnrajpbq',
                'folder'=>'events/'.$catName
            ]);
        } else {
            $uploadedFile = \Cloudinary\Uploader::unsigned_upload($entityInstance->getImageFile(),'xt0x0u4t',[
                'cloud_name' => 'hwnrajpbq',
                'folder'=>'events'
            ]);
        }
        foreach ($entityInstance->getEventDates() as $date ) {
            $entityManager->persist($date);
        }
        $entityInstance
            ->setImageFilename($uploadedFile['public_id'])
            ->setImageFile(null)
        ;
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $catName = strtolower(str_replace('&','-',str_replace(' ','-',$entityInstance->getCategory()->getName())));
        if ($entityInstance->getImageFile()) {
            $uploadedFile = \Cloudinary\Uploader::unsigned_upload($entityInstance->getImageFile(),'xt0x0u4t',[
                'cloud_name' => 'hwnrajpbq',
                'folder'=>'events/'.$catName
            ]);
            $entityInstance
                ->setImageFilename($uploadedFile['public_id'])
                ->setImageFile(null)
            ;
            // $this->addFlash('success',$entityInstance->getImageFilename());
        }
        foreach ($entityInstance->getEventDates() as $date ) {
            $entityManager->persist($date);
        }
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');
        $title = TextField::new('title');
        $description = TextEditorField::new('description','Details');
        $venue = TextField::new('venue');
        $publish = BooleanField::new('publish');
        $featured = BooleanField::new('featured');
        $category = AssociationField::new('category');
        $eventDates = CollectionField::new('eventDates')
            ->setEntryType(EventDateTimeType::class)
            ->setFieldFqcn(EventDates::class)
        ;
        $association = AssociationField::new('association');
        // $imageFilename = ImageField::new('imageFilename')
        //     -> onlyOnIndex()
        //     ->setBasePath('uploads/images/events')
        // ;
        $imageFile = ImageField::new('imageFile')
            ->onlyOnForms()
            ->setFormType(VichImageType::class)
            ->setRequired(false)
        ;

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $title, $publish, $featured, $venue, $association];
        } else if (Crud::PAGE_NEW === $pageName || Crud::PAGE_EDIT === $pageName) {
            return [$imageFile, $title, $description, $eventDates, $venue, $publish, $featured, $category, $association];
        }
    }
}
