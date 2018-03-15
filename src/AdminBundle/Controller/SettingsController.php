<?php

namespace AdminBundle\Controller;

use BaseBundle\BundleTrait;
use BaseBundle\Entity\Setting;
use Doctrine\DBAL\Query\QueryBuilder;
use Svi\HttpBundle\Forms\Form;
use Svi\OrmBundle\Entity;

class SettingsController extends CrudController
{
    use BundleTrait;

	public function indexAction()
	{
		$this->getSettingsService()->updateDatabase();

		return parent::indexAction();
	}

	protected function buildForm(Form $form, Entity $entity)
	{
		$type = $this->getSettingsService()->getSettingType($entity->getKey());
		if ($type == 'wysiwyg') {
			$form->add('value', 'textarea', array(
				'label' => $this->getSettingsService()->getSettingName($entity->getKey()),
				'data' => $entity->getValue(),
				'required' => false,
				'attr' => array(
					'data-wysiwyg' => true,
				),
			));
		} else {
			$form->add('value', $type, array(
				'label' => $this->getSettingsService()->getSettingName($entity->getKey()),
				'data' => $entity->getValue(),
				'required' => false,
			));
		}

	}

	protected function modifyQuery(QueryBuilder $builder)
	{
		$keys = $this->getSettingsService()->getSettingsKeys();
		$skeys = '';
		$i = 0;
		foreach ($this->getSettingsService()->getSettingsKeys() as $key) {
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
		return $this->getSettingManager();
	}

	protected function getListColumns()
	{
		$settingsService = $this->getSettingsService();

		return array(
			'key' => [
				'title' => 'Название настройки',
				'value' => function(Setting $s) use ($settingsService) {
					return $settingsService->getSettingName($s->getKey());
				}
            ],
			'value' => [
				'title' => 'Значение',
				'value' => function(Setting $s) {
					return substr($s->getValue(), 0, 256);
				}
            ],
		);
	}

	protected function getRoutes()
	{
		return array(
			'edit' => '_admin_settings_edit',
		);
	}

} 