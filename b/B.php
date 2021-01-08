<?php

namespace b;

use Craft;
use craft\web\twig\variables\CraftVariable;
use yii\base\Event;
use yii\base\InvalidConfigException;
use yii\base\Module;

/**
 * Custom Business Logic
 */
class B extends Module
{

	/**
	 * Initializes the module.
	 */
	public function init ()
	{
		Craft::setAlias('@b', __DIR__);

		if (Craft::$app->getRequest()->getIsConsoleRequest())
			$this->controllerNamespace = 'modules\\console\\controllers';
		else
			$this->controllerNamespace = 'modules\\controllers';

		parent::init();

		// Events
		// ---------------------------------------------------------------------

		Event::on(
			CraftVariable::class,
			CraftVariable::EVENT_INIT,
			[$this, 'onRegisterVariable']
		);
	}

	// Events
	// =========================================================================

	/**
	 * @param Event $event
	 *
	 * @throws InvalidConfigException
	 */
	public function onRegisterVariable (Event $event)
	{
		/** @var CraftVariable $variable */
		$variable = $event->sender;
		$variable->set('b', Variable::class);
	}

}
