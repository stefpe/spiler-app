<?php

namespace App\Components\DisplayPresets;

/**
 * Interface DisplayPresetAdjusterInterface
 * @package AppBundle\Components\DisplayPresets
 */
interface DisplayPresetAdjusterInterface
{
    /**
     * Prepare data to be displayed in the timeline.
     * @param array $data
     * @return array
     */
    public function getTimelineData(array $data): array;

    public function getFlowgraphData(array $data);
}
