<?php
/**
 * Created by PhpStorm.
 * User: sanderhagenaars
 * Date: 18/12/2018
 * Time: 09.20
 */

namespace NobrainerWeb\Fluent\BuildTasks;

use Sheadawson\Linkable\Models\Link;
use SilverStripe\Assets\File;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\BuildTask;
use SilverStripe\Versioned\Versioned;
use TractorCow\Fluent\Model\Locale;

class ToggleFilteredLocales extends BuildTask
{
    protected $title = 'Attach locales to FluentFiltered objects';
    protected $description = 'Attach all locales to specific objects with FluentFiltered extension';

    private static $models = [
        SiteTree::class,
        File::class
    ];

    /**
     * @param HTTPRequest $request
     * @return
     */
    public function run($request)
    {
        $locales = Locale::get()->column('ID');

        if(empty($locales)){
            echo 'No locales found. Maybe you should run ' . DefaultLocalesTask::class . '?';
            return;
        }

        foreach (self::config()->models as $model){
            $this->findAndAttach($model, $locales);
        }
    }

    public function findAndAttach($model, $locales)
    {
        foreach ($model::get() as $obj){
            if(!$obj->hasMethod('FilteredLocales') || $obj->FilteredLocales()->exists()){
                echo $obj->getTitle() . ' does not have the FilteredLocales method, or it already has some locales attached - ' . $obj->ClassName;
                echo '<br>';
                continue;
            }

            echo 'found ' . $obj->getTitle();
            echo '<br>';
            foreach ($locales as $locale) {
                $obj->FilteredLocales()->add($locale);
                echo 'added locale ' . $locale . ' to ' . $obj->getTitle();
                echo '<br>';
            }

            $obj->write();

            if($obj->hasExtension(Versioned::class)){

                $isPublished = $obj->isLiveVersion();
                $obj->writeToStage(Versioned::DRAFT);
                if($isPublished){
                    $obj->publishRecursive();
                }
            }
        }
    }
}