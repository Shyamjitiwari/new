<?php

namespace App\Domain;
use App\LanguageLine;

class Partners_page_strings
{
    public static function add_partner_page_strings_into_database(){
        // 1
        LanguageLine::create([
            'group' => 'partners',
            'key' => 'partners_with_us',
            'text' => ['en' => 'Partner with us. Anywhere in the world.'],
        ]);
        // 2
        LanguageLine::create([
            'group' => 'partners',
            'key' => 'partners_with_us_details',
            'text' => ['en' => 'Our partnerships have no limits on creativity. Whatever your idea is, or your needs are, contact us and we might be able to create a great partnership. We have worked with organizations of all sorts, including schools, large businesses, non-profits, tutoring centers, international product developers, unions, clubs, and more. We would love to hear your partnership idea!'],
        ]);
        // 3
        LanguageLine::create([
            'group' => 'partners',
            'key' => 'send_us_your_partnership_idea',
            'text' => ['en' => 'Send us your partnership idea'],
        ]);
        // 4
        LanguageLine::create([
            'group' => 'partners',
            'key' => 'fill_partners_form',
            'text' => ['en' => 'You can either fill in this form or email partners@codewithus.com. Either way, we\'re looking forward to talking to new partners.'],
        ]);
    }

    public static function addPartnersTranslationsForCanadianLocale(){
        // 1
        $language = LanguageLine::where(['key' => 'partners_with_us', 'group' => 'partners'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 2
        $language = LanguageLine::where(['key' => 'partners_with_us_details', 'group' => 'partners'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 3
        $language = LanguageLine::where(['key' => 'send_us_your_partnership_idea', 'group' => 'partners'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 4
        $language = LanguageLine::where(['key' => 'fill_partners_form', 'group' => 'partners'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
    }
}