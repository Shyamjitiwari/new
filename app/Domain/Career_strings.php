<?php

namespace App\Domain;
use App\LanguageLine;

class Career_strings
{
    public static function add_career_strings_into_database(){
        // 1
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'for_adults',
            'text' => ['en' => 'For Adults'],
        ]);
        // 2
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'coding_bootcamp_title',
            'text' => ['en' => 'Coding bootcamps'],
        ]);
        // 3
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'for_career_goals',
            'text' => ['en' => 'for career goals'],
        ]);
        // 4
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'one_to_one_education',
            'text' => ['en' => 'Amazing one-on-one education'],
        ]);
        // 5
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'experienced_instructor',
            'text' => ['en' => 'Experienced instructors'],
        ]);
        // 6
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'classes_on_your_schedule',
            'text' => ['en' => 'Classes on your schedule'],
        ]);
        // 7
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'online_or_in_person',
            'text' => ['en' => 'Online or in-person'],
        ]);
        // 8
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'guaranteed_satisfaction',
            'text' => ['en' => 'Satisfaction guaranteed!'],
        ]);
        // 9
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'trial_session',
            'text' => ['en' => 'Self-schedule a Trial Session'],
        ]);
        // 10
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'topic_options',
            'text' => ['en' => 'See topic options'],
        ]);
        // 11
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'prices_options',
            'text' => ['en' => 'See the prices'],
        ]);
        // 12
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'our_options_title',
            'text' => ['en' => 'Our Options'],
        ]);
        // 13
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'our_options',
            'text' => ['en' => 'We have 3 options. All bootcamps are done through one-on-one instruction.'],
        ]);
        // 14
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'career_builder_title',
            'text' => ['en' => 'Career Builder!'],
        ]);
        // 15
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'career_builder_option_one_title',
            'text' => ['en' => 'Option 1: <br>APPLIED DATA SCIENCE WITH PYTHON'],
        ]);
        // 16
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'career_builder_option_one',
            'text' => ['en' => 'Gain the career-building Python skills you need to succeed as a data scientist. No prior coding experience is required. In this course, you\'ll learn how to prepare, manipulate, and visualize data using Python. Every lesson will include a hands-on project that our teachers will assist to design. You\'ll work with real-world datasets to learn statistical and machine learning techniques.'],
        ]);
        // 17
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'learn_more',
            'text' => ['en' => 'Learn More'],
        ]);
        // 18
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'self_schedule_a_trial_session',
            'text' => ['en' => 'Self-schedule a Trial Session'],
        ]);
        // 19
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'career_builder_option_two_title',
            'text' => ['en' => 'Option 2: <br>WEB DEVELOPMENT WITH HTML, CSS AND JAVASCRIPT'],
        ]);
        // 20
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'career_builder_option_two',
            'text' => ['en' => 'This course is designed for creative individuals who are planning to pursue the highly sought-after career in web development. As businesses are transitioning from a traditional brick-and-mortar model to eCommerce, the demand for web developers is simply limitless. This course will guide you to become an entry-level web developer who can comfortably work in a team environment to design, modify and maintain corporate websites.'],
        ]);
        // 21
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'career_builder_option_three_title',
            'text' => ['en' => 'Option 3:<br>COMPLETELY CUSTOMIZED EDUCATION'],
        ]);
        // 22
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'career_builder_option_three',
            'text' => ['en' => 'If the above 2 options are not what you are looking for, take advantage of our ability to highly personalize our education to you. Because all of our adult education is one-on-one, we can make a custom 16 lesson plan for you based on your goals, needs, and more. You can choose other topics like Java, R programming, or App Development. If you think Option 3 is best for you, please spend time during your free Introduction to Programming to tell your teacher about your interests.'],
        ]);
        // 23
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'prices_title',
            'text' => ['en' => 'Prices'],
        ]);
        // 24
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'after_the_trial_session',
            'text' => ['en' => 'After the trial session'],
        ]);
        // 25
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'first_class',
            'text' => ['en' => 'First Class'],
        ]);
        // 26
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'currency_symbol',
            'text' => ['en' => '$',"en-GB" =>"£","en-AU" =>"AU$"],
        ]);
        // 27
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'first_class_price',
            'text' => ['en' => '0'],
        ]);
        // 28
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'trial_class',
            'text' => ['en' => 'trial class'],
        ]);
        // 29
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'free_start',
            'text' => ['en' => 'Free to start coding with us'],
        ]);
        // 30
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'meet_a_teacher',
            'text' => ['en' => 'Meet a teacher'],
        ]);
        // 31
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'ask_us_questions',
            'text' => ['en' => 'Ask us questions'],
        ]);
        // 32
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'small_group_class_3_to_1',
            'text' => ['en' => 'Small-group class (3-to-1)'],
        ]);
        // 33
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'one_to_one_trial_additional_price',
            'text' => ['en' => 'Add $10 for one-on-one trial','en-GB' => 'Add £8 for one-on-one trial', 'en-AU' => 'Add AU$10 for one-on-one trial'],
        ]);
        // 34
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'small_group_class',
            'text' => ['en' => 'Small-group class'],
        ]);
        // 35
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'small_group_class_original_price',
            'text' => ['en' => '37',"en-GB" =>"30","en-AU" =>"54"],
        ]);
        // 36
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'small_group_class_discount_price',
            'text' => ['en' => '29.5',"en-GB" =>"24","en-AU" =>"43"],
        ]);
        // 37
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'pre_paid_4_classes',
            'text' => ['en' => 'pre-paid 4 classes at a time'],
        ]);
        // 38
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'one_on_one_classes',
            'text' => ['en' => '>One-on-one class'],
        ]);
        // 39
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'one_on_one_class_original_price',
            'text' => ['en' => '60',"en-GB" =>"49","en-AU" =>"87"],
        ]);
        // 40
        LanguageLine::create([
            'group' => 'Career',
            'key' => 'one_on_one_class_discount_price',
            'text' => ['en' => '49.5',"en-GB" =>"40","en-AU" =>"72"],
        ]);
    }

    public static function addCareerTranslationsForAnotherLocale(){
        // 1
        $language = LanguageLine::where(['key' => 'for_adults', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 2
        $language = LanguageLine::where(['key' => 'coding_bootcamp_title', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 3
        $language = LanguageLine::where(['key' => 'for_career_goals', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 4
        $language = LanguageLine::where(['key' => 'one_to_one_education', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 5
        $language = LanguageLine::where(['key' => 'experienced_instructor', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 6
        $language = LanguageLine::where(['key' => 'classes_on_your_schedule', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
 
        // 7
        $language = LanguageLine::where(['key' => 'online_or_in_person', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
 
        // 8
        $language = LanguageLine::where(['key' => 'guaranteed_satisfaction', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
 
        // 9
        $language = LanguageLine::where(['key' => 'trial_session', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
 
        // 10
        $language = LanguageLine::where(['key' => 'topic_options', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 11
        $language = LanguageLine::where(['key' => 'prices_options', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 12
        $language = LanguageLine::where(['key' => 'our_options_title', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 13
        $language = LanguageLine::where(['key' => 'our_options', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 14
        $language = LanguageLine::where(['key' => 'career_builder_title', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 15
        $language = LanguageLine::where(['key' => 'career_builder_option_one_title', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 16
        $language = LanguageLine::where(['key' => 'career_builder_option_one', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
 
        // 17
        $language = LanguageLine::where(['key' => 'learn_more', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
 
        // 18
        $language = LanguageLine::where(['key' => 'self_schedule_a_trial_session', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
 
        // 19
        $language = LanguageLine::where(['key' => 'career_builder_option_two_title', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 20
        $language = LanguageLine::where(['key' => 'career_builder_option_two', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 21
        $language = LanguageLine::where(['key' => 'career_builder_option_three_title', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 22
        $language = LanguageLine::where(['key' => 'career_builder_option_three', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 23
        $language = LanguageLine::where(['key' => 'prices_title', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 24
        $language = LanguageLine::where(['key' => 'after_the_trial_session', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 25
        $language = LanguageLine::where(['key' => 'first_class', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 26
        $language = LanguageLine::where(['key' => 'currency_symbol', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => 'C$');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
 
        // 27
        $language = LanguageLine::where(['key' => 'first_class_price', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
 
        // 28
        $language = LanguageLine::where(['key' => 'trial_class', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 29
        $language = LanguageLine::where(['key' => 'free_start', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
 
        // 30
        $language = LanguageLine::where(['key' => 'meet_a_teacher', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 31
        $language = LanguageLine::where(['key' => 'ask_us_questions', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 32
        $language = LanguageLine::where(['key' => 'small_group_class_3_to_1', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 33
        $language = LanguageLine::where(['key' => 'one_to_one_trial_additional_price', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => 'Add C$14 for one-on-one trial');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 34
        $language = LanguageLine::where(['key' => 'small_group_class', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 35
        $language = LanguageLine::where(['key' => 'small_group_class_original_price', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => '50');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 36
        $language = LanguageLine::where(['key' => 'small_group_class_discount_price', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => '40');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 37
        $language = LanguageLine::where(['key' => 'pre_paid_4_classes', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
 
        // 38
        $language = LanguageLine::where(['key' => 'one_on_one_classes', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
 
        // 39
        $language = LanguageLine::where(['key' => 'one_on_one_class_original_price', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => '82');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
 
        // 40
        $language = LanguageLine::where(['key' => 'one_on_one_class_discount_price', 'group' => 'Career'])->first();
        $new_locale_and_translation = array('en-CA' => '67');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
    }
}