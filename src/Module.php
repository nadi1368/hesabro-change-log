<?php

namespace hesabro\changelog;

use Yii;
use yii\base\Module as BaseModule;
use hesabro\helpers\Module as HesabroHelpersModule;
use yii\i18n\PhpMessageSource;

class Module extends BaseModule
{
    public string $mongoConnection = 'mongodb';

    public array $ignoreClasses = [];

    public string | null $user;

    public function init(): void
    {
        parent::init();

        $this->registerTranslation();

        $this->setModules([
            'helpers' => [
                'class' => HesabroHelpersModule::class,
            ]
        ]);
    }

    private function registerTranslation(): void
    {
        Yii::$app->i18n->translations['hesabro/changelog*'] = [
            'class' => PhpMessageSource::class,
            'basePath' => '@hesabro/changelog/messages',
            'sourceLanguage' => 'en-US',
            'fileMap' => [
                'hesabro/changelog/module' => 'module.php'
            ],
        ];
    }

    public static function t($category, $message, $params = [], $language = null): string
    {
        return Yii::t('hesabro/changelog/' . $category, $message, $params, $language);
    }
}
