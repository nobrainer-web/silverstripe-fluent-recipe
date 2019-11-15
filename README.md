# silverstripe-fluent-recipe
Base setup for using the Fluent module, providing some examples for use, and some useful build tasks
- SilverStripe 4
- PHP 7

## Installation
Copy the `fluent.yml.example` file into your project's config folder and remove the file to have a valid yml extension.
In this file you should also add/edit the desired default_locales. It's also recommended to add remaining fluent configuration and extensions to this file as well.

After moving the config file and adding locales, run the `DefaultLocalesTask` to generate the specified locales, and subsequently the `ToggleFilteredLocales` to attach existing page structure to the given language layers.

## Caveat
It is recommended to install Fluent as early in the project development as possible, as doing it later can cause non-default language layers to overwrite data in the default language layer if the default layer is not first saved to the database. This caveat has minor impact to new projects if Fluent is installed early in the process, but can wreak havoc on existing projects with large amounts of content. 
