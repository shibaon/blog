<?php

namespace Kh\AdminBundle\Controller;

use Doctrine\DBAL\Query\QueryBuilder;
use Svi\BaseBundle\Entity\Setting;
use Svi\BaseBundle\Forms\Form;
use Svi\BaseBundle\Manager\SettingManager;
use Svi\Entity;

class SettingsController extends CrudController
{

	public function indexAction()
	{
		$this->c->getSviBaseBundle()->getSettingsService()->updateDatabase();

		return parent::indexAction();
	}

	protected function buildForm(Form $form, Entity $entity)
	{
		$type = $this->c->getSviBaseBundle()->getSettingsService()->getSettingType($entity->getKey());
		if ($type == 'wysiwyg') {
			$form->add('value', 'textarea', array(
				'label' => $this->c->getSettingsService()->getSettingName($entity->getKey()),
				'data' => $entity->getValue(),
				'required' => false,
				'attr' => array(
					'data-wysiwyg' => true,
				),
			));
		} else {
			$form->add('value', $type, array(
				'label' => $this->c->getSviBaseBundle()->getSettingsService()->getSettingName($entity->getKey()),
				'data' => $entity->getValue(),
				'required' => false,
			));
		}

	}

	protected function modifyQuery(QueryBuilder $builder)
	{
		$keys = $this->c->getSviBaseBundle()->getSettingsService()->getSettingsKeys();
		$skeys = '';
		$i = 0;
		foreach ($this->c->getSviBaseBundle()->getSettingsService()->getSettingsKeys() as $key) {
			$i++;
			$skeys .= $builder->getConnection()->quote($key);
			if (count($keys) != $i) {
				$skeys .= ', ';
			}
		}
		if ($skeys) {
			$builder->andWhere('skey IN (' . $skeys . ')');
		} else {
			$builder->andWhere('1 = 0');
		}
	}

	protected function getManager()
	{
		return $this->c->getSviBaseBundle()->getSettingsManager();
	}

	protected function getListColumns()
	{
		$settingsService = $this->c->getSviBaseBundle()->getSettingsService();

		return array(
			'skey' => array(
				'title' => 'Название настройки',
				'value' => function(Setting $s) use ($settingsService) {
					return $settingsService->getSettingName($s->getKey());
				}
			),
			'value' => array(
				'title' => 'Значение',
				'value' => function(Setting $s) {
					return substr($s->getValue(), 0, 256);
				}
			),
		);
	}

	protected function getRoutes()
	{
		return array(
			'edit' => '_admin_settings_edit',
		);
	}

} 