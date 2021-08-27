<?php

namespace Seche\NovaJstree;

use Laravel\Nova\Fields\Field;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class Jstree extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'jstree';

    protected $data; // array

    /**
     * Default Settings
     *
     * @param string $name
     * @param string|null $attribute
     * @param callable|null $resolveCallback
     *
     */
    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        $this->withMeta(['token' => 'j' . Str::random(8)]);

        $this->withMeta(['searchBtn' => __('Add Search Results')]);
        $this->withMeta(['searchPlaceholder' => __('Search Placeholder')]);
        $this->withMeta(['openAllBtn' => __('Open All')]);
        $this->withMeta(['closeAllBtn' => __('Close All')]);

        $this->withMeta(
            ['theme' => [
                'dots' => true,
                'icons' => true,
                'stripes' => true,
                'name' => 'default', // default-dark
                'variant' => 'small' // small, large, null
                ]
        ]);

        $this->withMeta(
            ['types' => [
                '#' => ['max_children' => 1,
                        'max_depth' => 4,
                        'valid_children'=> ['root']
                ],
                'root' => [
                    'icon' => 'fa fa-hdd text-yellow',
                    'valid_children' => ['default', 'file']
                ],
                'default' => [
                    'icon' => 'fa fa-folder text-yellow',
                    'valid_children' => ['default','file']
                ],
                'file' => [
                    'icon' => 'fa fa-file',
                    'valid_children' => []
                ],
                'text' =>[
                    'icon' => 'far fa-file-alt',
                    'valid_children' => []
                ],
                'word' => [
                    'icon' => 'far fa-file-word',
                    'valid_children' => []
                ],
                'excel' => [
                    'icon' => 'far fa-file-excel',
                    'valid_children' => []
                ],
                'ppt' => [
                    'icon' => 'far fa-file-powerpoint',
                    'valid_children' => []
                ],
                'pdf' => [
                    'icon' => 'far fa-file-pdf',
                    'valid_children' => []
                ],
                'archive' => [
                    'icon' => 'far fa-file-archive',
                    'valid_children' => []
                ],
                'image' => [
                    'icon' => 'far fa-file-image',
                    'valid_children' => []
                ],
                'audio' => [
                    'icon' => 'far fa-file-audio',
                    'valid_children' => []
                ],
                'video' => [
                    'icon' => 'far fa-file-video',
                    'valid_children' => []
                ]
            ]
        ]);

        $this->withMeta(
            ['checkbox' => [
                'visible' => false,
                'three_state' => true,
                'keep_selected_style' => true,
                'whole_node' => true
            ]
        ]);

        $this->withMeta(
            ['search' => [
                'visible' => false,
                'show_only_matches' => true,
                'case_sensitive' => false,
                'fuzzy' => false,
                'show_only_matches_children' => false
            ]
        ]);

        $this->withMeta(
            ['openCloseAllBtns' => [
                'visible' => false
            ]
        ]);

        parent::__construct($name, $attribute, $resolveCallback);
    }

    /**
     * Set the theme settings.
     *
     * @param  array  $settings
     * @return $this
     */
    public function theme(array $settings)
    {
        return $this->withMeta(['theme' => $settings]);
    }

    /**
     * Set the types settings.
     *
     * @param  array  $settings
     * @return $this
     */
    public function types(array $settings)
    {
        return $this->withMeta(['types' => $settings]);
    }

    /**
     * Set the checkbox settings.
     *
     * @param  array|null  $settings
     * @return $this
     */
    public function checkbox(array $settings = null)
    {
        if(empty($settings)) $settings = ['visible' => true];
        return $this->withMeta(['checkbox' => $settings]);
    }

    /**
     * Set the search settings.
     *
     * @param  array|null  $settings
     * @return $this
     */
    public function search(array $settings = null)
    {
        if(empty($settings)) $settings = ['visible' => true];
        return $this->withMeta(['search' => $settings]);
    }

    /**
     * Show Open All / Close All Buttons.
     * @params none
     * @return $this
     */
    public function openCloseAllBtns(): Jstree
    {
        return $this->withMeta(['openCloseAllBtns' => ['visible' => true]]);
    }

    /**
     * Set the data.
     *
     * @param  array|null  $data
     * @return $this
     */
    public function data(array $data = null)
    {
        return $this->withMeta(['core' => ['data' =>  $this->createAlternativeNode($data)]]);
    }

    private function createAlternativeNode(array $data, string $parent = '#'): array
    {
        // Create a single level array with id and parent values
        $returnValue = array();
        $token = data_get($this->Meta(), 'token');

        // Set Default Parent in case it is not included in array
        if(array_key_exists('parent', $data))
            $parent = $data['parent'];

        if(count($data) > 1){
            foreach($data as $key => $value){
                if(!is_numeric($key)){
                    switch ($key){
                        case 'id':
                            if($parent !== '#' && strpos($parent, $token) !== false)
                                $returnValue['id']  = $parent . '_' . $value;
                            else
                                if($parent !== '#')
                                    $returnValue['id'] = $token . '_' . $parent . '_' . $value;
                                else
                                    $returnValue['id'] = $token . '_' . $value;
                            break;
                        case 'name':
                        case 'title':
                        case 'text':
                            $returnValue['text'] = $value;
                            break;
                        case 'parent':
                            if($value !== '#' && strpos($value, $token) === false)
                                $value = $token. '_' . $value;
                            $returnValue['parent'] = $value;
                            break;
                        case 'icon':
                        case 'type':
                        case 'state':
                        case 'li_attr':
                        case 'a_attr':
                        case 'data':
                            $returnValue[$key] = $value;
                            break;
                        case 'children':
                            $returnValue['children'] = $this->createAlternativeNode($value, $returnValue['id']);
                            break;
                        default:
                            break;
                    }

                    if(!array_key_exists('parent', $returnValue))
                        $returnValue['parent'] = $parent;
                }
                else{
                    if(is_array($value))
                        $returnValue[] = $this->createAlternativeNode($value, $parent);
                    else
                        $returnValue[] = ['id' => $value, 'text' => $value];

                }
            }
        }
        else {
            $returnValue[] = ['id' => $data, 'text' => $data];
        }

        return $returnValue;
    }
}
