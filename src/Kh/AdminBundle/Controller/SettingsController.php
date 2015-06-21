<?php

namespace Kh\AdminBundle\Controller;

use Doctrine\DBAL\Query\QueryBuilder;
use Sv\BaseBundle\Entity\Setting;
use Sv\BaseBundle\Forms\Form;

class SettingsController extends CrudController
{

	public function indexAction()
	{
		$this->c->getSettingsManager()->updateDatabase();

		return parent::indexAction();
	}

	protected function buildForm(Form $form, $entity)
	{
		$type = $this->c->getSettingsManager()->getSettingType($entity->getKey());
		if ($type == 'wysiwyg') {
			$form->add('value', 'textarea', array(
				'label' => $this->c->getSettingsManager()->getSettingName($entity->getKey()),
				'data' => $entity->getValue(),
				'required' => false,
				'attr' => array(
					'data-wysiwyg' => true,
				),
			));
		} else {
			$form->add('value', $type, array(
				'label' => $this->c->getSettingsManager()->getSettingName($entity->getKey()),
				'data' => $entity->getValue(),
				'required' => false,
			));
		}

	}

	protected function modifyQuery(QueryBuilder $builder)
	{
		$keys = $this->c->getSettingsManager()->getSettingsKeys();
		$skeys = '';
		$i = 0;
		foreach ($this->c->getSettingsManager()->getSettingsKeys() as $key) {
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

	protected function getClassName()
	{
		return 'Sv\\BaseBundle\\Entity\\Setting';
	}

	protected function getListColumns()
	{
		$settingsManager = $this->c->getSettingsManager();

		return array(
			'skey' => array(
				'title' => 'Название настройки',
				'value' => function(Setting $s) use ($settingsManager) {
					return $settingsManager->getSettingName($s->getKey());
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