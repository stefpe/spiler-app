<?php

namespace App\Components\DisplayPresets;

/**
 * Class DisplayPresetAdjusterFactory
 * @package AppBundle\Components\DisplayPresets
 */
class DisplayPresetAdjusterFactory
{
    /**
     * @param string $presetName
     * @return DisplayPresetAdjusterInterface
     */
    public static function getDisplayPresetAdjuster(string $presetName): DisplayPresetAdjusterInterface
    {
        $className = __NAMESPACE__ . '\\' . $presetName . 'DisplayPresetAdjuster';

        if(class_exists($className)){
            return new $className();
        }

        return new NullDisplayPresetAdjuster();
    }
}
