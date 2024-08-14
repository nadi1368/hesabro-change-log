<?php
class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication
     */
    public static $app;
}

/**
 * @property yii\mongodb\Connection $mongodb
 */
abstract class BaseApplication extends \yii\base\Application {}
