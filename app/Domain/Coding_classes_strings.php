<?php

namespace App\Domain;
use App\LanguageLine;

class Coding_classes_strings
{
    public static function add_coding_classes_strings_into_database(){
        // 1
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'for_all_ages',
            'text' => ['en' => 'For all ages 5-18'],
        ]);
        // 2
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'personalized',
            'text' => ['en' => '100% personalized'],
        ]);
        // 3
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'coding_education',
            'text' => ['en' => 'coding education'],
        ]);
        // 4
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'classes_on_your_schedule',
            'text' => ['en' => 'Classes on your schedule.'],
        ]);
        // 5
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'topics',
            'text' => ['en' => '13+ topics. We\'ll help you pick.'],
        ]);
        // 6
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'private_or_small_group',
            'text' => ['en' => ' Private or in small-group.'],
        ]);
        // 7
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'online_or_in_person',
            'text' => ['en' => ' Online or in-person.'],
        ]);
        // 8
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'instructor',
            'text' => ['en' => ' Caring, knowledgeable instructors!'],
        ]);
        // 9
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'learn_more',
            'text' => ['en' => 'Learn more'],
        ]);
        // 10
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'see_the_prices',
            'text' => ['en' => 'See the prices'],
        ]);
        // 11
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'try_a_class_for_free',
            'text' => ['en' => 'Try a class for free'],
        ]);
        // 12
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'trial_class_sign_up',
            'text' => ['en' => '1 hour Trial Class Signup'],
        ]);
        // 13
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'self_schedule_trial_session',
            'text' => ['en' => 'Self-schedule a trial session below. It is free for a trial small-group session or $10 for a trial one-on-one private session.'],
        ]);
        // 14
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'email_id',
            'text' => ['en' => 'Email Address'],
        ]);
        // 15
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'password',
            'text' => ['en' => 'Password'],
        ]);
        // 16
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'sign_up',
            'text' => ['en' => 'Sign up'],
        ]);
        // 17
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'personalized_coding_education_title',
            'text' => ['en' => 'Personalized Coding Education'],
        ]);
        // 18
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'personalized_coding_education',
            'text' => ['en' => 'Our classes allow students age 5 through 18 to personalized coding education that fits their interests and goals. Because each student is unique, each student will receive a custom curriculum designed just for them. We have 13+ programming languages for the student to try, and hundreds of projects they can work on with their teacher, in order to gain the necessary skills.'],
        ]);
        // 19
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'about_us_title',
            'text' => ['en' => 'About Us'],
        ]);
        // 20
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'about_us',
            'text' => ['en' => ' We teach 1-on-1 or 3-on-1 coding classes to students. Our goal is to inspire students to solve problems creatively, logically and collaboratively. Students will learn to create video games, robots, websites, virtual reality apps, and much more! Programming languages include Scratch, Python, Javascript, and others. No prior experience necessary. Our teachers are based in Silicon Valley!'],
        ]);
        // 21
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'one_more_thing_title',
            'text' => ['en' => 'One more thing...'],
        ]);
        // 22
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'one_more_thing',
            'text' => ['en' =>  'Students can pick the topic based on their age! Topics include Robotics, Python, Javascript, Scratch, and much more.
                                    Don\'t forget about our 100% Satisfaction Guarantee. If the student or their parent is not satisfied at any time during camp, we will provide a full refund and still perform the camp!
                                    <br><br>
                                    <b>Did you know?</b>
                                    <br>
                                    Learning to code at an early age encourages creative thinking and problem-solving skills. Studies have shown it also helps unlock cognitive functions. Try a FREE coding class below!'],
        ]);
        // 23
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'prices_title',
            'text' => ['en' => 'Prices'],
        ]);
        // 24
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'coding_classes_for_kids',
            'text' => ['en' => 'Coding classes for kids and teens.'],
        ]);
        // 25
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'group_classes',
            'text' => ['en' => 'Group classes'],
        ]);
        // 26
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'currency_symbol',
            'text' => ['en' => '$','en-GB'=>'£', 'en-AU' => 'AU$'],
        ]);
        // 27
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'group_classes_original_price',
            'text' => ['en' => '37','en-GB'=>'30', 'en-AU' => '54'],
        ]);
        // 28
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'group_classes_discount_price',
            'text' => ['en' => '29','en-GB'=>'23', 'en-AU' => '42'],
        ]);
        // 29
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'per_class',
            'text' => ['en' => 'Per class (Online or In-person)'],
        ]);
        // 30
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'students_per_class',
            'text' => ['en' => '3 students per class'],
        ]);
        // 31
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'availability',
            'text' => ['en' => 'Available 7 days a week, 12 hours a day'],
        ]);
        // 32
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'topics_based_on_age',
            'text' => ['en' => 'Topics based on age'],
        ]);
        // 33
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'money_back_guarantee',
            'text' => ['en' => 'Money back guarantee!'],
        ]);
        // 34
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'private_classes',
            'text' => ['en' => 'Private classes'],
        ]);
        // 35
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'private_classes_original_price',
            'text' => ['en' => '37','en-GB'=>'48', 'en-AU' => '87'],
        ]);
        // 36
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => 'private_classes_discount_price',
            'text' => ['en' => '29','en-GB'=>'23', 'en-AU' => '42'],
        ]);
        // 37
        LanguageLine::create([
            'group' => 'coding_classes',
            'key' => '1_on_1_classes',
            'text' => ['en' => '1 on 1 classes'],
        ]);
    }

    public static function addCodingClassesTranslationsForAnotherLocale(){
        // 1
        $language = LanguageLine::where(['key' => 'for_all_ages', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 2
        $language = LanguageLine::where(['key' => 'personalized', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 3
        $language = LanguageLine::where(['key' => 'coding_education', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 4
        $language = LanguageLine::where(['key' => 'classes_on_your_schedule', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 5
        $language = LanguageLine::where(['key' => 'topics', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 6
        $language = LanguageLine::where(['key' => 'private_or_small_group', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 7
        $language = LanguageLine::where(['key' => 'online_or_in_person', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 8
        $language = LanguageLine::where(['key' => 'instructor', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 9
        $language = LanguageLine::where(['key' => 'learn_more', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 10
        $language = LanguageLine::where(['key' => 'see_the_prices', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 11
        $language = LanguageLine::where(['key' => 'try_a_class_for_free', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 12
        $language = LanguageLine::where(['key' => 'trial_class_sign_up', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 13
        $language = LanguageLine::where(['key' => 'self_schedule_trial_session', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 14
        $language = LanguageLine::where(['key' => 'email_id', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 15
        $language = LanguageLine::where(['key' => 'password', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 16
        $language = LanguageLine::where(['key' => 'sign_up', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 17
        $language = LanguageLine::where(['key' => 'personalized_coding_education_title', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 18
        $language = LanguageLine::where(['key' => 'personalized_coding_education', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 19
        $language = LanguageLine::where(['key' => 'about_us_title', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 20
        $language = LanguageLine::where(['key' => 'about_us', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 21
        $language = LanguageLine::where(['key' => 'one_more_thing_title', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 22
        $language = LanguageLine::where(['key' => 'one_more_thing', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 23
        $language = LanguageLine::where(['key' => 'prices_title', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 24
        $language = LanguageLine::where(['key' => 'coding_classes_for_kids', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 25
        $language = LanguageLine::where(['key' => 'group_classes', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 26
        $language = LanguageLine::where(['key' => 'currency_symbol', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => 'C$');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 27
        $language = LanguageLine::where(['key' => 'group_classes_original_price', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => '50');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 28
        $language = LanguageLine::where(['key' => 'group_classes_discount_price', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => '40');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 29
        $language = LanguageLine::where(['key' => 'per_class', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 30
        $language = LanguageLine::where(['key' => 'students_per_class', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 31
        $language = LanguageLine::where(['key' => 'availability', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 32
        $language = LanguageLine::where(['key' => 'topics_based_on_age', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 33
        $language = LanguageLine::where(['key' => 'money_back_guarantee', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 34
        $language = LanguageLine::where(['key' => 'private_classes', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 35
        $language = LanguageLine::where(['key' => 'private_classes_original_price', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => '50');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 36
        $language = LanguageLine::where(['key' => 'private_classes_discount_price', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => '40');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 37
        $language = LanguageLine::where(['key' => '1_on_1_classes', 'group' => 'coding_classes'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
    }
}