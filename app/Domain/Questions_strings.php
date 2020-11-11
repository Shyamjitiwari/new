<?php

namespace App\Domain;
use App\LanguageLine;

class Questions_strings
{
    public static function add_questions_strings_into_database(){
        // 1
        LanguageLine::create([
            'group' => 'Questions',
            'key' => 'questions_title',
            'text' => ['en' => 'Questions'],
        ]);
        // 2
        LanguageLine::create([
            'group' => 'Questions',
            'key' => 'contacting_is_easy',
            'text' => ['en' => 'Contacting us is easy!'],
        ]);
        // 3
        LanguageLine::create([
            'group' => 'Questions',
            'key' => 'four_options',
            'text' => ['en' => 'You have 4 options:'],
        ]);
        // 4
        LanguageLine::create([
            'group' => 'Questions',
            'key' => 'contact_us_option_one',
            'text' => ['en' => '1. Start a live chat at the bottom-right of this page'],
        ]);
        // 5
        LanguageLine::create([
            'group' => 'Questions',
            'key' => 'contact_us_option_two',
            'text' => ['en' => '2. Email info@codewithus.com'],
        ]);
        // 6
        LanguageLine::create([
            'group' => 'Questions',
            'key' => 'contact_us_option_three',
            'text' => ['en' => '3. Text (408) 909-7717'],
        ]);
        // 7
        LanguageLine::create([
            'group' => 'Questions',
            'key' => 'contact_us_option_four',
            'text' => ['en' => '4. Call (408) 909-7717'],
        ]);
        // 8
        LanguageLine::create([
            'group' => 'Questions',
            'key' => 'check_our_homepage_at',
            'text' => ['en' => 'If you haven\'t already, check out our homepage at <a href="https://www.codewithus.com/">https://www.codewithus.com/</a>.<br> <br>'],
        ]);
    }
    public static function addPartnersTranslationsForCanadianLocale(){
        // 1
        $language = LanguageLine::where(['key' => 'questions_title', 'group' => 'Questions'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 2
        $language = LanguageLine::where(['key' => 'contacting_is_easy', 'group' => 'Questions'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 3
        $language = LanguageLine::where(['key' => 'four_options', 'group' => 'Questions'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 4
        $language = LanguageLine::where(['key' => 'contact_us_option_one', 'group' => 'Questions'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 5
        $language = LanguageLine::where(['key' => 'contact_us_option_two', 'group' => 'Questions'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 6
        $language = LanguageLine::where(['key' => 'contact_us_option_three', 'group' => 'Questions'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 7
        $language = LanguageLine::where(['key' => 'contact_us_option_four', 'group' => 'Questions'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 8
        $language = LanguageLine::where(['key' => 'check_our_homepage_at', 'group' => 'Questions'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
    }
}