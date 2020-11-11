<?php

namespace App\Domain;
use App\LanguageLine;

class NY_page_strings
{
    public static function add_NY_page_strings_into_database(){
        // 1
        LanguageLine::create([
            'group' => 'NY_page',
            'key' => 'ages',
            'text' => ['en' => 'For ages 5-18'],
        ]);
        // 2
        LanguageLine::create([
            'group' => 'NY_page',
            'key' => 'exciting_coding_camps',
            'text' => ['en' => 'Exciting coding camps'],
        ]);
        // 3
        LanguageLine::create([
            'group' => 'NY_page',
            'key' => 'yelp_partnership',
            'text' => ['en' => 'in partnership with MyPrep in New York!'],
        ]);
        // 4
        LanguageLine::create([
            'group' => 'NY_page',
            'key' => 'reference_for_refund',
            'text' => ['en' => 'Enter "MyPrep" as referrer for $10 refund'],
        ]);
        // 5
        LanguageLine::create([
            'group' => 'NY_page',
            'key' => 'intructors',
            'text' => ['en' => 'Patient, experienced camp instructors'],
        ]);
        // 6
        LanguageLine::create([
            'group' => 'NY_page',
            'key' => 'personalized',
            'text' => ['en' => 'Personalized to student\'s age'],
        ]);
        // 7
        LanguageLine::create([
            'group' => 'NY_page',
            'key' => 'choice_of_days_and_hours',
            'text' => ['en' => 'Choice of number of days and hours'],
        ]);
        // 8
        LanguageLine::create([
            'group' => 'NY_page',
            'key' => 'several_topics',
            'text' => ['en' => 'Several topics to explore'],
        ]);
        // 9
        LanguageLine::create([
            'group' => 'NY_page',
            'key' => 'online_or_inperson',
            'text' => ['en' => 'Online or in-person'],
        ]);
        // 10
        LanguageLine::create([
            'group' => 'NY_page',
            'key' => 'learn_more',
            'text' => ['en' => 'Learn more'],
        ]); 
        // 11
        LanguageLine::create([
            'group' => 'NY_page',
            'key' => 'see_the_prices',
            'text' => ['en' => 'See the prices'],
        ]); 
        // 12
        LanguageLine::create([
            'group' => 'NY_page',
            'key' => 'signup',
            'text' => ['en' => 'Signup'],
        ]); 
    }

    public static function addNY_PageTranslationsForCanadianLocale(){
        // 1
        $language = LanguageLine::where(['key' => 'ages', 'group' => 'NY_page'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 2
        $language = LanguageLine::where(['key' => 'exciting_coding_camps', 'group' => 'NY_page'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 3
        $language = LanguageLine::where(['key' => 'yelp_partnership', 'group' => 'NY_page'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 4
        $language = LanguageLine::where(['key' => 'reference_for_refund', 'group' => 'NY_page'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 5
        $language = LanguageLine::where(['key' => 'intructors', 'group' => 'NY_page'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 6
        $language = LanguageLine::where(['key' => 'personalized', 'group' => 'NY_page'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 7
        $language = LanguageLine::where(['key' => 'choice_of_days_and_hours', 'group' => 'NY_page'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 8
        $language = LanguageLine::where(['key' => 'several_topics', 'group' => 'NY_page'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 9
        $language = LanguageLine::where(['key' => 'online_or_inperson', 'group' => 'NY_page'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 10
        $language = LanguageLine::where(['key' => 'learn_more', 'group' => 'NY_page'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 11
        $language = LanguageLine::where(['key' => 'see_the_prices', 'group' => 'NY_page'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 12
        $language = LanguageLine::where(['key' => 'signup', 'group' => 'NY_page'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
    }
}