<?php

namespace NobrainerWeb\Fluent\Extensions;

use SilverStripe\Forms\FieldList;
use TractorCow\Fluent\Model\Locale;

class FluentInvisibleFilterExtension extends FluentFilteredExtension
{
    private static $translate = ['Title'];

    public function updateCMSFields(FieldList $fields): void
    {
        parent::updateCMSFields($fields);
        $fields->removeByName('FilteredLocales');
    }

    public function onBeforeWrite()
    {
        foreach (Locale::get() as $locale) {
            $this->owner->FilteredLocales()->add($locale);
        }
    }
}
