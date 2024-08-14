<?php

namespace hesabro\changelog;

use Yii;
use yii\base\Module as BaseModule;
use yii\i18n\PhpMessageSource;

class Module extends BaseModule
{
    public string | null $user;

    public array $ignoreClasses = [];

    public string | null $mongo_dns;

    public function init(): void
    {
        parent::init();
        $this->registerTranslation();
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
