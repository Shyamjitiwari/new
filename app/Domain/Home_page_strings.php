<?php

namespace App\Domain;
use App\LanguageLine;

class Home_page_strings
{
    public static function add_home_page_strings_into_database(){
        // 1
        LanguageLine::create([
            'group' => 'home',
            'key' => 'coding_education',
            'text' => ['en' => 'Coding Education'],
        ]);
        // 2
        LanguageLine::create([
            'group' => 'home',
            'key' => 'for_all_ages',
            'text' => ['en' => 'For All Ages'],
        ]);
        // 3
        LanguageLine::create([
            'group' => 'home',
            'key' => 'lessons_with_real_teachers',
            'text' => ['en' => 'Personalized lessons with real teachers.'],
        ]);
        // 4
        LanguageLine::create([
            'group' => 'home',
            'key' => 'for_kids_teens_and_adults',
            'text' => ['en' => 'For ages 5 through 18.'],
        ]);
        // 5
        LanguageLine::create([
            'group' => 'home',
            'key' => 'in_person_or_online',
            'text' => ['en' => 'In-person or online.'],
        ]);
        // 6
        LanguageLine::create([
            'group' => 'home',
            'key' => 'schedule_a_trial_session',
            'text' => ['en' => 'Schedule a Free Session'],
        ]);
        // 7
        LanguageLine::create([
            'group' => 'home',
            'key' => 'see_our_camps',
            'text' => ['en' => 'See our camps'],
        ]);
        // 8
        LanguageLine::create([
            'group' => 'home',
            'key' => 'we_teach_topics',
            'text' => ['en' => 'We teach 13+ topics including'],
        ]);
        // 9
        LanguageLine::create([
            'group' => 'home',
            'key' => 'students_can_select_projects',
            'text' => ['en' => 'Students can select the types of projects they want to create. Then, we recommend the languages based on their skill level and interests. Some of the programming languages we teach are:'],
        ]);
        // 10
        LanguageLine::create([
            'group' => 'home',
            'key' => 'code_applications',
            'text' => ['en' => 'Code Applications'],
        ]);
        // 11
        LanguageLine::create([
            'group' => 'home',
            'key' => 'with_python',
            'text' => ['en' => 'with Python'],
        ]);
        // 12
        LanguageLine::create([
            'group' => 'home',
            'key' => 'minecraft',
            'text' => ['en' => 'Minecraft MODS'],
        ]);
        // 13
        LanguageLine::create([
            'group' => 'home',
            'key' => 'with_javascript',
            'text' => ['en' => 'with JavaScript'],
        ]);
        // 14
        LanguageLine::create([
            'group' => 'home',
            'key' => 'create_games',
            'text' => ['en' => 'Create Games'],
        ]);
        // 15
        LanguageLine::create([
            'group' => 'home',
            'key' => 'with_scratch',
            'text' => ['en' => 'with Scratch'],
        ]);
        // 16
        LanguageLine::create([
            'group' => 'home',
            'key' => 'virtual_reality',
            'text' => ['en' => 'Virtual Reality'],
        ]);
        // 17
        LanguageLine::create([
            'group' => 'home',
            'key' => 'with_unity',
            'text' => ['en' => 'with Unity'],
        ]);
        // 18
        LanguageLine::create([
            'group' => 'home',
            'key' => '3d_painting',
            'text' => ['en' => '3D Printing'],
        ]);
        // 19
        LanguageLine::create([
            'group' => 'home',
            'key' => 'with_tinkercad',
            'text' => ['en' => 'with Tinkercad'],
        ]);
        // 20
        LanguageLine::create([
            'group' => 'home',
            'key' => 'robotics',
            'text' => ['en' => 'Robotics'],
        ]);
        // 21
        LanguageLine::create([
            'group' => 'home',
            'key' => 'with_arduino',
            'text' => ['en' => 'with Arduino C++'],
        ]);
        // 22
        LanguageLine::create([
            'group' => 'home',
            'key' => 'trusted_by_silicon',
            'text' => ['en' => 'Trusted by Silicon Valley'],
        ]);
        // 23
        LanguageLine::create([
            'group' => 'home',
            'key' => 'innovative_tech_companies',
            'text' => ['en' => 'Some of the most innovative technology companies in the world have hired us to teach their employees and employee\'s children.'],
        ]);
        // 24
        LanguageLine::create([
            'group' => 'home',
            'key' => 'is_there_any_money_back_guarantee',
            'text' => ['en' => 'Is there a money back guarantee?'],
        ]);
        // 25
        LanguageLine::create([
            'group' => 'home',
            'key' => 'money_back_guarantee',
            'text' => ['en' => 'Yup! We provide a 100% money-back guarantee with all of our services. If you are not satisfied, let us know at the end of your first session and we will make sure to refund your payment.Yup! We provide a 100% money-back guarantee with all of our services. If you are not satisfied, let us know at the end of your first session and we will make sure to refund your payment.'],
        ]);
        // 26
        LanguageLine::create([
            'group' => 'home',
            'key' => 'can_i_see_reviews',
            'text' => ['en' => 'Can I see some of your reviews?'],
        ]);
        // 27
        LanguageLine::create([
            'group' => 'home',
            'key' => 'yelp_link',
            'text' => ['en' => 'Of course! Check us out here: <a href="https://www.yelp.com/biz/code-with-us-campbell">See Reviews</a>'],
        ]);
        // 28
        LanguageLine::create([
            'group' => 'home',
            'key' => 'how_to_get_help',
            'text' => ['en' => 'How to get help'],
        ]);
    }

    public static function addHomeTranslationsForCanadianLocale(){
        // 1
        $language = LanguageLine::where(['key' => 'coding_education', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 2
        $language = LanguageLine::where(['key' => 'for_all_ages', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 3
        $language = LanguageLine::where(['key' => 'lessons_with_real_teachers', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 4
        $language = LanguageLine::where(['key' => 'for_kids_teens_and_adults', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 5
        $language = LanguageLine::where(['key' => 'in_person_or_online', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 6
        $language = LanguageLine::where(['key' => 'schedule_a_trial_session', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 7
        $language = LanguageLine::where(['key' => 'see_our_camps', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 8
        $language = LanguageLine::where(['key' => 'we_teach_topics', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 9
        $language = LanguageLine::where(['key' => 'students_can_select_projects', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 10
        $language = LanguageLine::where(['key' => 'code_applications', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 11
        $language = LanguageLine::where(['key' => 'with_python', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 12
        $language = LanguageLine::where(['key' => 'minecraft', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 13
        $language = LanguageLine::where(['key' => 'with_javascript', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 14
        $language = LanguageLine::where(['key' => 'create_games', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 15
        $language = LanguageLine::where(['key' => 'with_scratch', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 16
        $language = LanguageLine::where(['key' => 'virtual_reality', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 17
        $language = LanguageLine::where(['key' => 'with_unity', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 18
        $language = LanguageLine::where(['key' => '3d_painting', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 19
        $language = LanguageLine::where(['key' => 'with_tinkercad', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 20
        $language = LanguageLine::where(['key' => 'robotics', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 21
        $language = LanguageLine::where(['key' => 'with_arduino', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 22
        $language = LanguageLine::where(['key' => 'trusted_by_silicon', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 23
        $language = LanguageLine::where(['key' => 'innovative_tech_companies', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 24
        $language = LanguageLine::where(['key' => 'is_there_any_money_back_guarantee', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 25
        $language = LanguageLine::where(['key' => 'money_back_guarantee', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 26
        $language = LanguageLine::where(['key' => 'can_i_see_reviews', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 27
        $language = LanguageLine::where(['key' => 'yelp_link', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 28
        $language = LanguageLine::where(['key' => 'how_to_get_help', 'group' => 'home'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
    }
}