<?php
/**
 * Created by PhpStorm.
 * User: sanderhagenaars
 * Date: 2019-06-07
 * Time: 13:59
 */

namespace NobrainerWeb\Fluent\Extensions;


use SilverStripe\ORM\DataExtension;
use TractorCow\Fluent\Model\Locale;

class FluentFilteredExtension extends \TractorCow\Fluent\Extension\FluentFilteredExtension
{
    public function onBeforeWrite()
    {
        // add all locales to a newly created page automatically
        if ($this->owner->hasMethod('FilteredLocales') && !$this->owner->isInDB() && !$this->owner->FilteredLocales()->exists()) {
            $locales = Locale::get();
            foreach ($locales as $locale) {
                $this->owner->FilteredLocales()->add($locale);
            }
        }
    }
}