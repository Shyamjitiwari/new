<?php

namespace App\Domain;
use App\LanguageLine;

class Options_for_classes_strings
{
    public static function add_options_for_classes_strings_into_database(){
        // 1
        LanguageLine::create([
            'group' => 'options_for_classes',
            'key' => 'our_options',
            'text' => ['en' => 'For ages 5 through 18:'],
        ]);
        // 2
        LanguageLine::create([
            'group' => 'options_for_classes',
            'key' => 'ongoing_lessons',
            'text' => ['en' => 'Ongoing Lessons'],
        ]);
        // 3
        LanguageLine::create([
            'group' => 'options_for_classes',
            'key' => 'one_hour_long_lesson',
            'text' => ['en' => 'each lesson is one hour long'],
        ]);
        // 4
        LanguageLine::create([
            'group' => 'options_for_classes',
            'key' => 'for_students',
            'text' => ['en' => 'For ages 5 through 18'],
        ]);
        // 5
        LanguageLine::create([
            'group' => 'options_for_classes',
            'key' => 'choose',
            'text' => ['en' => 'Choose:'],
        ]);
        // 6
        LanguageLine::create([
            'group' => 'options_for_classes',
            'key' => 'in_person_or_online',
            'text' => ['en' => 'in-person or online'],
        ]);
        // 7
        LanguageLine::create([
            'group' => 'options_for_classes',
            'key' => 'private_or_small_group',
            'text' => ['en' => 'private or small-group'],
        ]);
        // 8
        LanguageLine::create([
            'group' => 'options_for_classes',
            'key' => 'your_own_schedule',
            'text' => ['en' => 'your own schedule'],
        ]);
        // 9
        LanguageLine::create([
            'group' => 'options_for_classes',
            'key' => 'topics',
            'text' => ['en' => 'one of 13+ topics'],
        ]);
        // 10
        LanguageLine::create([
            'group' => 'options_for_classes',
            'key' => 'learn_more',
            'text' => ['en' => 'Learn More'],
        ]);
        // 11
        LanguageLine::create([
            'group' => 'options_for_classes',
            'key' => 'camps',
            'text' => ['en' => 'Camps'],
        ]);
        // 12
        LanguageLine::create([
            'group' => 'options_for_classes',
            'key' => 'days',
            'text' => ['en' => '4 days or 5 days'],
        ]);
        // 13
        LanguageLine::create([
            'group' => 'options_for_classes',
            'key' => 'hours',
            'text' => ['en' => '3 hrs or 7 hrs per day'],
        ]);
        // 14
        LanguageLine::create([
            'group' => 'options_for_classes',
            'key' => 'any_week',
            'text' => ['en' => 'any week'],
        ]);
        // 15
        LanguageLine::create([
            'group' => 'options_for_classes',
            'key' => 'private_career_builder_bootcamp',
            'text' => ['en' => 'Private Career-Builder Bootcamp'],
        ]);
        // 16
        LanguageLine::create([
            'group' => 'options_for_classes',
            'key' => 'one_to_one_bootcamp',
            'text' => ['en' => 'A one-on-one bootcamp geared to adults that want to enhance their career options by learning how to code. Through one-on-one instruction, over 16 lessons scheduled based on your needs, you will finish this course with a strong foundation and knowledge of how to navigate the coding industry.'],
        ]);
    }
    public static function addOptions_for_ClassesTranslationsForCanadianLocale(){
        // 1
        $language = LanguageLine::where(['key' => 'our_options', 'group' => 'options_for_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 2
        $language = LanguageLine::where(['key' => 'ongoing_lessons', 'group' => 'options_for_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 3
        $language = LanguageLine::where(['key' => 'one_hour_long_lesson', 'group' => 'options_for_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 4
        $language = LanguageLine::where(['key' => 'for_students', 'group' => 'options_for_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 5
        $language = LanguageLine::where(['key' => 'choose', 'group' => 'options_for_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 6
        $language = LanguageLine::where(['key' => 'in_person_or_online', 'group' => 'options_for_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 7
        $language = LanguageLine::where(['key' => 'private_or_small_group', 'group' => 'options_for_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 8
        $language = LanguageLine::where(['key' => 'your_own_schedule', 'group' => 'options_for_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 9
        $language = LanguageLine::where(['key' => 'topics', 'group' => 'options_for_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 10
        $language = LanguageLine::where(['key' => 'learn_more', 'group' => 'options_for_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 11
        $language = LanguageLine::where(['key' => 'camps', 'group' => 'options_for_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 12
        $language = LanguageLine::where(['key' => 'days', 'group' => 'options_for_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 13
        $language = LanguageLine::where(['key' => 'hours', 'group' => 'options_for_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 14
        $language = LanguageLine::where(['key' => 'any_week', 'group' => 'options_for_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 15
        $language = LanguageLine::where(['key' => 'private_career_builder_bootcamp', 'group' => 'options_for_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 16
        $language = LanguageLine::where(['key' => 'one_to_one_bootcamp', 'group' => 'options_for_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
    }
}