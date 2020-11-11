<?php

namespace App\Domain;
use App\LanguageLine;

class Camps_strings
{
    public static function add_camps_strings_into_database(){
        // 1
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'age_for_camps',
            'text' => ['en' => 'For ages 5-18','en-CA' => 'Canada'],
        ]);
        // 2
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'exciting_code_camps',
            'text' => ['en' => 'Exciting coding camps'],
        ]);
        // 3
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'every_week_availability',
            'text' => ['en' => 'available every week'],
        ]);
        // 4
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'camps_instructors',
            'text' => ['en' => 'Patient, experienced camp instructors'],
        ]);
        // 5
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'personalized_student_age',
            'text' => ['en' => 'Personalized to student\'s age'],
        ]);
        // 6
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'camps_days_and_hours',
            'text' => ['en' => 'Choice of number of days and hours'],
        ]);
        // 7
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'camps_several_topics',
            'text' => ['en' => 'Several topics to explore'],
        ]);
        // 8
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'camps_online_or_inperson',
            'text' => ['en' => 'Online or in-person'],
        ]);
        // 9
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'camps_learn_more',
            'text' => ['en' => 'Learn more'],
        ]);
        // 10
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'camps_see_the_prices',
            'text' => ['en' => 'See the prices'],
        ]);
        // 11
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'camps_sign_up',
            'text' => ['en' => 'Signup'],
        ]);
        // 12
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'about_camps',
            'text' => ['en' => 'About Camp'],
        ]);
        // 13
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'camps_intro',
            'text' => ['en' => 'Our camps allow students between the ages of 5 and 18 to pursue a coding project, or multiple, with all the help and resources they need. This is thanks to our coding environment allowing students to pursue their creativity with a teacher-to-student ratio of 6-to-1.'],
        ]);
        // 14
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'project_based',
            'text' => ['en' => 'Project Based'],
        ]);
        // 15
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'educational_environment',
            'text' => ['en' => 'Our educational environment encourages students to create unique and custom projects. We recognize that coding is more fun when students have the resources, space, and time to create something great! That is why we provide everything necessary including very knowledge-able staff, experienced teachers, and high-end technology.'],
        ]);
        // 16
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'camps_also',
            'text' => ['en' => 'Also...'],
        ]);
        // 17
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'picking_up_project',
            'text' => ['en' => 'Students can pick the topic based on their age! Topics include Robotics, Python, Javascript, Scratch, and much more.'],
        ]);
        // 18
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'camps_prices_title',
            'text' => ['en' => 'Prices'],
        ]);
        // 19
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'camps_for_kids',
            'text' => ['en' => 'For kids coding camps.'],
        ]);
        // 20
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'half_week_camp_title',
            'text' => ['en' => 'Half-Day Week-long Camp'],
        ]);
        // 21
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'currency_symbol',
            'text' => ['en' => '$',"en-GB" =>"£","en-AU" =>"AU$"],
        ]);
        // 22
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'half_week_camp_original_price',
            'text' => ['en' => '470',"en-GB" =>"378","en-AU" =>"685"],
        ]);
        // 23
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'half_week_camp_discount_price',
            'text' => ['en' => '235',"en-GB" =>"189","en-AU" =>"342"],
        ]);
        // 24
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'half_week_camp_time_choices',
            'text' => ['en' => '2 Choices: 9AM to 12PM <b>OR</b> 1PM to 4PM',"en-GB" =>"2 Choices: 5PM to 8PM <b>OR</b> 9PM to 12AM","en-AU" =>"2 Choices: 2AM to 5AM <b>OR</b> 6AM to 9AM"],
        ]);
        // 25
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'half_week_camp_days',
            'text' => ['en' => '4 days (Mon-Thurs)'],
        ]);
        // 26
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'half_week_camp_add_friday_price',
            'text' => ['en' => 'Add friday for $60',"en-GB" =>"Add friday for £48","en-AU" =>"Add friday for AU$87"],
        ]);
        // 27
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'camps_topics_based_on_age',
            'text' => ['en' => 'Topics based on age'],
        ]);
        // 28
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'full_day_week_long_camp',
            'text' => ['en' => 'Full-Day Week-long Camp'],
        ]);
        // 29
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'full_day_week_long_camp_original_price',
            'text' => ['en' => '790',"en-GB" =>"635","en-AU" =>"1150"],
        ]);
        // 30
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'full_day_week_long_camp_discount_price',
            'text' => ['en' => '395',"en-GB" =>"317","en-AU" =>"575"],
        ]);
        // 31
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'full_day_week_long_camp_start_to_end_time',
            'text' => ['en' => '9AM to 4PM',"en-GB" =>"5PM to 12AM","en-AU" =>"2AM to 9AM"],
        ]);
        // 32
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'full_week_camp_days',
            'text' => ['en' => '4 days (Mon-Thurs)'],
        ]);
        // 33
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'full_day_week_long_camp_add_friday_price',
            'text' => ['en' => 'Add friday for $75',"en-GB" =>"Add friday for £60","en-AU" =>"Add friday for AU$109"],
        ]);
        // 34
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'camps_signup',
            'text' => ['en' => 'Camps Signup'],
        ]);
        // 35
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'multi_week_discount',
            'text' => ['en' => 'If you want to attend camp several weeks in the same season, please contact us for a multi-week discount.'],
        ]);
        // 36
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'customized_camp_schedule',
            'text' => ['en' => 'If none of these options work for you, or you want a customized camp schedule, please fill out '],
        ]);
        // 37
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'this_form',
            'text' => ['en' => 'this form'],
        ]);
        // 38
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'custom_camps_request',
            'text' => ['en' => 'Custom Camps Request'],
        ]);
        // 39
        LanguageLine::create([
            'group' => 'Camps',
            'key' => 'please_fillout_form',
            'text' => ['en' => 'Please either fill out this form to request a custom camp schedule, bulk and sibling pricing, or anything else that the normal signup process does not cover'],
        ]);
    }

    public static function addCampsTranslationsForCanadianLocale(){
        // 1
        $language = LanguageLine::where(['key'=>'age_for_camps', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 2
        $language = LanguageLine::where(['key'=>'exciting_code_camps', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
        
        // 3
        $language = LanguageLine::where(['key'=>'every_week_availability', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
        
        // 4
        $language = LanguageLine::where(['key'=>'camps_instructors', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();   

        // 5
        $language = LanguageLine::where(['key'=>'personalized_student_age', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 6
        $language = LanguageLine::where(['key'=>'camps_days_and_hours', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 7
        $language = LanguageLine::where(['key'=>'camps_several_topics', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 8
        $language = LanguageLine::where(['key'=>'camps_online_or_inperson', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 9
        $language = LanguageLine::where(['key'=>'camps_learn_more', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 10
        $language = LanguageLine::where(['key'=>'camps_see_the_prices', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 11
        $language = LanguageLine::where(['key'=>'camps_sign_up', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 12
        $language = LanguageLine::where(['key'=>'about_camps', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 13
        $language = LanguageLine::where(['key'=>'camps_intro', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 14
        $language = LanguageLine::where(['key'=>'project_based', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 15
        $language = LanguageLine::where(['key'=>'educational_environment', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 16
        $language = LanguageLine::where(['key'=>'camps_also', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 17
        $language = LanguageLine::where(['key'=>'picking_up_project', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 18
        $language = LanguageLine::where(['key'=>'camps_prices_title', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 19
        $language = LanguageLine::where(['key'=>'camps_for_kids', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 20
        $language = LanguageLine::where(['key'=>'half_week_camp_title', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 21
        $language = LanguageLine::where(['key'=>'currency_symbol', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => 'C$');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 22
        $language = LanguageLine::where(['key'=>'half_week_camp_original_price', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => '635');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 23
        $language = LanguageLine::where(['key'=>'half_week_camp_discount_price', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => '318');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 24
        $language = LanguageLine::where(['key'=>'half_week_camp_time_choices', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => '2 Choices: 12PM to 3PM <b>OR</b> 4PM to 7PM');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 25
        $language = LanguageLine::where(['key'=>'half_week_camp_days', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 26
        $language = LanguageLine::where(['key'=>'half_week_camp_add_friday_price', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => 'Add friday for $82');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 27
        $language = LanguageLine::where(['key'=>'camps_topics_based_on_age', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
           
        // 28
        $language = LanguageLine::where(['key'=>'full_day_week_long_camp', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
                    
        // 29
        $language = LanguageLine::where(['key'=>'full_day_week_long_camp_original_price', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' =>  '1070');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
                 
        // 30
        $language = LanguageLine::where(['key'=>'full_day_week_long_camp_discount_price', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => '534');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
                 
        // 31
        $language = LanguageLine::where(['key'=>'full_day_week_long_camp_start_to_end_time', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => '12PM to 7PM');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
                 
        // 32
        $language = LanguageLine::where(['key' => 'full_week_camp_days', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
                 
        // 33
        $language = LanguageLine::where(['key'=>'full_day_week_long_camp_add_friday_price', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' =>'Add friday for C$102');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
                 
        // 34
        $language = LanguageLine::where(['key'=>'camps_signup', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
                 
        // 35
        $language = LanguageLine::where(['key'=>'multi_week_discount', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
                 
        // 36
        $language = LanguageLine::where(['key'=>'customized_camp_schedule', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
                 
        // 37
        $language = LanguageLine::where(['key'=>'this_form', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
                 
        // 38
        $language = LanguageLine::where(['key'=>'custom_camps_request', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
                   
        // 39
        $language = LanguageLine::where(['key'=>'please_fillout_form', 'group' => 'Camps'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
    }
}