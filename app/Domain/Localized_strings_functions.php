<?php

namespace App\Domain;
use Spatie\TranslationLoader\LanguageLine;
use Config;

class Localized_strings_functions
{
    public static function get_all_localized_strings(){
        $currentAppLocale = Config::get('app.locale');

        $allWebsiteStrings = LanguageLine::all();
        $groups = array();
        foreach($allWebsiteStrings as $websiteString){
            array_push($groups, $websiteString->group);
        }
        $groups = array_unique($groups);

        $localizedStrings = array();
        foreach($groups as $group){
            $data = array();
            $stringsOfTheGroup = LanguageLine::where('group',$group)->get();
            foreach($stringsOfTheGroup as $stringOfTheGroup){
                $textLocales = $stringOfTheGroup->text;
                foreach($textLocales as $key => $value){
                    if($key == $currentAppLocale){
                        $data[$stringOfTheGroup->key] =  stripslashes($value);
                    }  
                }
            }

            $localizedStrings[$group] = $data;
        }

        return $localizedStrings;
    }
}