<?php

namespace App\Components\DisplayPresets;

/**
 * Class NullDisplayPresetAdjuster
 * @package AppBundle\Components\DisplayPresets
 */
class NullDisplayPresetAdjuster implements DisplayPresetAdjusterInterface
{
    public function getTimelineData(array $data): array
    {
        return $data;
    }

    public function getFlowgraphData(array $data)
    {
        return $data;
    }
}
