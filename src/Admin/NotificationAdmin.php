<?php

namespace App\Admin;

use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class NotificationAdmin extends AbstractAdmin
{
  /**
   * @var string
   */
  protected $baseRouteName = 'admin_catrobat_adminbundle_subscriptonsadmin';

  /**
   * @var string
   */
  protected $baseRoutePattern = 'subscriptions';

  /**
   * @param FormMapper $form
   *
   * Fields to be shown on create/edit forms
   */
  protected function configureFormFields(FormMapper $form): void
  {
    if ($this->isCurrentRoute('create')) {
      $form
        ->add('id', EntityType::class, ['class' => User::class, 'label' => 'User'])
      ;
    }

    if ($this->isCurrentRoute('edit')) {
      $form
        ->add('user', EntityType::class, ['class' => User::class, 'label' => 'User'])
      ;
    }

    $form
      ->add('upload', null, ['label' => 'Email bei Upload', 'required' => false])
      ->add('report', null,
        ['label' => 'Email bei Inappropriate Report', 'required' => false])
    ;
  }

  /**
   * @param DatagridMapper $filter
   *
   * Fields to be shown on filter forms
   */
  protected function configureDatagridFilters(DatagridMapper $filter): void
  {
    $filter
      ->add('user')
      ->add('user.email')
      ->add('upload')
      ->add('report')
    ;
  }

  /**
   * @param ListMapper $list
   *
   * Fields to be shown on lists
   */
  protected function configureListFields(ListMapper $list): void
  {
    $list
      ->add('user', EntityType::class, ['class' => User::class])
      ->add('user.email')
      ->add('upload', null, ['editable' => true])
      ->add('report', null, ['editable' => true])
      ->add('_action', 'actions', [
        'actions' => [
          'edit' => [],
          'delete' => [],
        ],
      ])
    ;
  }

  protected function configureRoutes(RouteCollection $collection): void
  {
    $collection->remove('acl');
  }
}
