<?php
/**
 * TModel
 **/
class TModel extends CModel
{
    /**
     * @var TTumblrConnection 
     * By default, this is the 'tumblr' application component.
     * @see getApi
     */
    public static $api;

    private static $_models=array();// class name => model

    /**
     * Returns the static model of the specified TModel class.
     * The model returned is a static instance of the TModel class.
     * It is provided for invoking class-level methods (something similar to static class methods.)
     *
     * EVERY derived TModel class must override this method as follows,
     * <pre>
     * public static function model($className=__CLASS__)
     * {
     *     return parent::model($className);
     * }
     * </pre>
     *
     * @param string $className tmodel class name.
     * @return TModel model instance.
     */
    public static function model($className=__CLASS__)
    {
        if(isset(self::$_models[$className]))
            return self::$_models[$className];
        else
            return self::$_models[$className]=new $className(null);
    }

    /**
     * @return TTumblrConnection the api connection used by tmodel.
     */
    public function getApi()
    {
        if(self::$api!==null)
            return self::$api;
        else
        {
            self::$api=Yii::app()->getApi();
            if(self::$api instanceof TTumblrConnection)
                return self::$api;
            else
                throw new CException(Yii::t('yii','TModel requires a "tumblt" TTumblrConnection application component.'));
        }
    }
}
