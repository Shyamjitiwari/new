<?php

namespace App\Domain;
use App\LanguageLine;

class Testimonials_strings
{
    public static function add_testimonial_strings_into_database(){
        // 1
        LanguageLine::create([
            'group' => 'testimonials',
            'key' => 'testimonial_from_Christine',
            'text' => ['en' => 'Testimonial from Christine K'],
        ]);
        // 2
        LanguageLine::create([
            'group' => 'testimonials',
            'key' => 'from_san_jose',
            'text' => ['en' => 'from San Jose, California'],
        ]);
        // 3
        LanguageLine::create([
            'group' => 'testimonials',
            'key' => 'christine_testimonial',
            'text' => ['en' => 'Yes, this place really is THAT great. Our 7 year old was designing and coding his own games after the 2nd class. Excellent teachers make this the only program that he actually wants to attend and looks forward to each week.'],
        ]);
        // 4
        LanguageLine::create([
            'group' => 'testimonials',
            'key' => 'teacher_pedro_spotlight',
            'text' => ['en' => 'Teacher Spotlight: Pedro Martinez'],
        ]);
        // 5
        LanguageLine::create([
            'group' => 'testimonials',
            'key' => 'about_pedro',
            'text' => ['en' => 'Pedro graduated from San Jose State University with a Management Information Systems degree. Pedro\'s goal is to encourage his students to be excited about STEM careers and work on interesting projects. In his spare time, Pedro likes to play soccer!'],
        ]);
    }
    public static function addTestimonialsTranslationsForCanadianLocale(){
        // 1
        $language = LanguageLine::where(['key' => 'testimonial_from_Christine', 'group' => 'testimonials'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 2
        $language = LanguageLine::where(['key' => 'from_san_jose', 'group' => 'testimonials'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 3
        $language = LanguageLine::where(['key' => 'christine_testimonial', 'group' => 'testimonials'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 4
        $language = LanguageLine::where(['key' => 'teacher_pedro_spotlight', 'group' => 'testimonials'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 5
        $language = LanguageLine::where(['key' => 'about_pedro', 'group' => 'testimonials'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
    }
}