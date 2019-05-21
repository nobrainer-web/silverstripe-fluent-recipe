<?php

namespace NobrainerWeb\Fluent\BuildTasks;

use TractorCow\Fluent\Model\Locale;

class DefaultLocalesTask extends \SilverStripe\Dev\BuildTask
{
    /**
     * @var string $title Shown in the overview on the {@link TaskRunner}
     * HTML or CLI interface. Should be short and concise, no HTML allowed.
     */
    protected $title = "Generate Default Fluent Locales";

    /**
     * @var string $description Describe the implications the task has,
     * and the changes it makes. Accepts HTML formatting.
     */
    protected $description = 'Creates default Fluent locales defined in config';

    /**
     * [
     *     da_DK => ['Title' => 'Dansk', 'URLSegment' => 'da', 'IsGlobalDefault' => 1]
     * ]
     *
     * @var array
     */
    private $default_locales = [];

    public function run($request)
    {
        $defaultLocales = self::config()->get("default_locales");
        $existingLocales = Locale::get()->column("Locale");

        foreach ($defaultLocales as $locale => $obj) {

            if (in_array($locale, $existingLocales)) {
                // exists already, dont create
                echo '<p>' . $obj['Title'] . ' exists already</p>';
                continue;
            }
            $obj['Locale'] = $locale;
            $locale = Locale::create($obj);
            $locale->write();
            echo '<p>' . $locale->Title . ' created</p>';
        }
    }
}