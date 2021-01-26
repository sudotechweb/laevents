<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Entity\EventDates;
use App\Form\EventDateTimeType;
use DateTime;
use DateTimeZone;
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
        if ($entityInstance->getImageFile()) {
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
            $entityInstance
                ->setImageFilename($uploadedFile['public_id'])
                ->setImageFile(null)
            ;
        }
        foreach ($entityInstance->getEventDates() as $date ) {
            $date = $this->setDateTimeForEvent($date);
            $entityManager->persist($date);
        }
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
            $date = $this->setDateTimeForEvent($date);
            $entityManager->persist($date);
        }
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    private function setDateTimeForEvent($date)
    {
        if ($date->getAllday()) {
            $date
                ->setStartingTime(new DateTime($date->getEventDate()->format('y-m-d 0800'), new DateTimeZone('Pacific/Port_Moresby')))
                ->setEndingTime(new DateTime($date->getEventDate()->format('y-m-d 1700'), new DateTimeZone('Pacific/Port_Moresby')))
            ;
        } else {
            $startTime = $date->getStartingTime()->format('H:i:s');
            $endTime = $date->getEndingTime()->format('H:i:s');
            $date
                ->setStartingTime(new DateTime($date->getEventDate()->format('y-m-d ').$startTime, new DateTimeZone('Pacific/Port_Moresby')))
                ->setEndingTime(new DateTime($date->getEventDate()->format('y-m-d ').$endTime, new DateTimeZone('Pacific/Port_Moresby')))
            ;
        }
        return $date;
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
            ->setRequired(false)
        ;
        $association = AssociationField::new('association');
        // $imageFilename = ImageField::new('imageFilename')
        //     -> onlyOnIndex()
        //     ->setBasePath('uploads/images/events')
        // ;
        $imageFile = ImageField::new('imageFile')
            ->setUploadDir('')
            ->setProperty('help')
            ->onlyOnForms()
            ->setFormType(VichImageType::class)
            ->setRequired(true)
        ;

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $title, $publish, $featured, $venue, $association];
        } else if (Crud::PAGE_NEW === $pageName || Crud::PAGE_EDIT === $pageName) {
            return [$imageFile, $title, $description, $eventDates, $venue, $publish, $featured, $category, $association];
        }
    }
}
