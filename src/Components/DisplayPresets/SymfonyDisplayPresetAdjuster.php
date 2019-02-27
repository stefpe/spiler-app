<?php

namespace App\Components\DisplayPresets;

/**
 * Class SymfonyDisplayPresetAdjuster
 * @package AppBundle\Components\DisplayPresets
 */
class SymfonyDisplayPresetAdjuster implements DisplayPresetAdjusterInterface
{

    private const FRAMEWORK = 'framework';
    private const EVENT = 'event';
    private const RENDERING = 'rendering';
    private const CONTROLLER = 'controller';
    private const DB = 'database';

    private const FUNCTION_NAME = 'fc';

    /**
     * {@inheritdoc}
     */
    public function getTimelineData(array $data): array
    {
        $appActions = [
            'Symfony\\Component\\HttpKernel\\Kernel::boot' => ['scl' => self::FRAMEWORK],
            'Symfony\\Component\\EventDispatcher\\ContainerAwareEventDispatcher::lazyLoad' => [
                'scl' => self::FRAMEWORK,
                'detail_info' => function ($elem) {
                    return ['Event' => $elem['pa'][0]];
                }
            ],
            'Symfony\\Component\\HttpKernel\\HttpCache\\HttpCache::lock' => ['scl' => self::FRAMEWORK],
            'Symfony\\Component\\HttpKernel\\HttpCache\\HttpCache::forward' => ['scl' => self::FRAMEWORK],
            'Symfony\\Component\\EventDispatcher\\EventDispatcher::dispatch' => [
                'scl' => self::EVENT,
                self::FUNCTION_NAME => function ($elem) {
                    return 'Event=>' . $elem['pa'][0];
                },
                'detail_info' => function ($elem) {
                    return ['Event' => $elem['pa'][0]];
                }
            ],
            'Symfony\\Bundle\\TwigBundle\\TwigEngine::render' => [
                'scl' => self::RENDERING,
                'detail_info' => function ($elem) {
                    return ['Template' => $elem['pa'][0]];
                }],
            'Twig_Template::render' => ['scl' => self::RENDERING],
            'Twig_Template::display' => ['scl' => self::RENDERING],
            'Symfony\\Component\\HttpFoundation\\Response::send' => ['scl' => self::FRAMEWORK],
            'Symfony\\Component\\HttpKernel\\Kernel::terminate' => ['scl' => self::FRAMEWORK],
        ];

        $controller = preg_grep('/::.*Action/i', array_column($data['cs'], self::FUNCTION_NAME));

        foreach ($data['cs'] as $key => &$item) {
            if (isset($appActions[$item[self::FUNCTION_NAME]])) {
                $override = $appActions[$item[self::FUNCTION_NAME]];
                $override = array_map(function ($elem) use ($item) {
                    return (is_callable($elem)) ? $elem($item) : $elem;
                }, $override);
                $item = array_merge($item, $override);
            } elseif (isset($controller[$key])) {
                $item['scl'] = self::CONTROLLER;
            } else {
                unset($data['cs'][$key]);
            }
        }

        /*echo "<pre>";
        print_r($data['cs']);
        die();*/

        $data['cs'] = array_values($data['cs']);

        return $data;
    }

    public function getFlowgraphData(array $data)
    {

        //$data['cs'] = array_slice($data['cs'],0, 20);

        foreach ($data['cs'] as $key => &$item) {


            /*if($item[self::FUNCTION_NAME] === 'Symfony\\Component\\HttpKernel\\Kernel::handle'){
                continue;
            }

            if($item[self::FUNCTION_NAME] === 'Symfony\\Component\\HttpKernel\\Kernel::terminate'){
                continue;
            }


             unset($data['cs'][$key]);*/

        }

        $data['cs'] = array_values($data['cs']);

        return $data;
    }
}
