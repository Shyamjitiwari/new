<?php

namespace App\Domain;
use App\LanguageLine;

class Camps_prices_and_time
{
    public static function add_camps_prices_and_time_strings_into_database(){
        // 1
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'pick_a_location',
            'text' => ['en' => 'Pick A Location','en-CA' => 'Pick A Location','en-AU' => 'Pick A Location','en-GB'=>'Pick A Location'],
        ]);
        // 2
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'camps_title',
            'text' => ['en' => 'Camps','en-CA' => 'Camps','en-AU' => 'Camps','en-GB'=>'Camps'],
        ]);
        // 3
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'camps_dates',
            'text' => ['en' => 'Camp Dates','en-CA' => 'Camp Dates','en-AU' => 'Camp Dates','en-GB'=> 'Camp Dates'],
        ]);
        // 4
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'topic_title',
            'text' => ['en' => 'Topics','en-CA' => 'Topics','en-AU' => 'Topics','en-GB'=> 'Topics'],
        ]);
        // 5
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'loading',
            'text' => ['en' => 'Loading...','en-CA' => 'Loading...','en-AU' => 'Loading...','en-GB'=> 'Loading...'],
        ]);
        // 6
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'week_of',
            'text' => ['en' => 'Week Of','en-CA' => 'Week Of','en-AU' => 'Week Of','en-GB'=> 'Week Of'],
        ]);
        // 7
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'full',
            'text' => ['en' => 'Full','en-CA' => 'Full','en-AU' => 'Full','en-GB'=> 'Full'],
        ]);
        // 8
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'almost_full',
            'text' => ['en' => 'Almost Full','en-CA' => 'Almost Full','en-AU' => 'Almost Full','en-GB'=> 'Almost Full'],
        ]);
        // 9
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'from',
            'text' => ['en' => 'From','en-CA' => 'From','en-AU' => 'From','en-GB'=> 'From'],
        ]);
        // 10
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'not_available',
            'text' => ['en' => 'Not Available','en-CA' => 'Not Available','en-AU' => 'Not Available','en-GB'=> 'Not Available'],
        ]);
        // 11
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'register_for_camp_sessions',
            'text' => ['en' => 'Register for Camp Sessions','en-CA' => 'Register for Camp Sessions','en-AU' => 'Register for Camp Sessions','en-GB'=> 'Register for Camp Sessions'],
        ]);
        // 12
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'half_day_part_one',
            'text' => ['en' => 'Half-day 9am-12pm (PST) at','en-CA' => 'Half-day 12pm-3pm (EDT) at','en-AU' => 'Half-day 2am-3am (AST) at','en-GB'=> 'Half-day 5pm-8pm (BST) at'],
        ]);
        // 13
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'half_day_part_two',
            'text' => ['en' => 'Half-day 1pm-4pm (PST) at','en-CA' => 'Half-day 4pm-7pm (EDT) at','en-AU' => 'Half-day 6am-9am (AST) at','en-GB'=> 'Half-night 9pm-1am (BST) at'],
        ]);
        // 14
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'full_day_session',
            'text' => ['en' => 'Full-day 9am-4pm (PST) at','en-CA' => 'Full-day 12pm-7pm (EDT) at','en-AU' => 'Full-day 2am-9am (AST) at','en-GB'=> 'Full-day 5pm-12am (BST) at'],
        ]);
        // 15
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'optional_friday_title',
            'text' => ['en' => 'Optional Friday','en-CA' => 'Optional Friday','en-AU' => 'Optional Friday','en-GB'=> 'Optional Friday'],
        ]);
        // 16
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'friday_half_part_one',
            'text' => ['en' => 'Friday Half-day at','en-CA' => 'Friday Half-day at','en-AU' => 'Friday Half-day at','en-GB'=> 'Friday Half-day at'],
        ]);
        // 17
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'friday_full_day_session',
            'text' => ['en' => 'Friday Full-day 9am-4pm (PST) at','en-CA' => 'Friday Full-day 12pm-7pm (EDT) at','en-AU' => 'Friday Full-day 2am-9am (AST) at','en-GB'=> 'Friday Full-day 5pm-12am (BST) at'],
        ]);
        // 18
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'birthday',
            'text' => ['en' => 'Birthday','en-CA' => 'Birthday','en-AU' => 'Birthday','en-GB'=> 'Birthday'],
        ]);
        // 19
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'currency_symbol',
            'text' => ['en' => '$','en-CA' => 'CA$','en-AU' => 'AU$','en-GB'=> '£'],
        ]);
        // 20
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'following_amount_will_be_charged',
            'text' => ['en' => 'will be charged for the selected coding camp sessions.','en-CA' => 'will be charged for the selected coding camp sessions.','en-AU' => 'will be charged for the selected coding camp sessions.','en-GB'=> 'will be charged for the selected coding camp sessions.'],
        ]);
         // 21
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'thankyou_title',
            'text' => ['en' => 'THANK YOU!','en-CA' => 'THANK YOU!','en-AU' => 'THANK YOU!','en-GB'=> 'THANK YOU!'],
        ]);
        // 22
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'thankyou_message',
            'text' => ['en' => 'You have successfully registered for our coding camps sessions. Click on the link below to login you account and view details',
                       'en-CA' => 'You have successfully registered for our coding camps sessions. Click on the link below to login you account and view details',
                       'en-AU' => 'You have successfully registered for our coding camps sessions. Click on the link below to login you account and view details',
                       'en-GB'=> 'You have successfully registered for our coding camps sessions. Click on the link below to login you account and view details'
                      ],
        ]);
        // 23
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'sign_in_title',
            'text' => ['en' => 'Sign In','en-CA' => 'Sign In','en-AU' => 'Sign In','en-GB'=> 'Sign In'],
        ]);
        // 24
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'student_name_title',
            'text' => ['en' => 'Student\'s Name','en-CA' => 'Student\'s Name','en-AU' => 'Student\'s Name','en-GB'=> 'Student\'s Name'],
        ]);
        // 25
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'email_title',
            'text' => ['en' => 'Email','en-CA' => 'Email','en-AU' => 'Email','en-GB'=> 'Email'],
        ]);
        // 26
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'phone_number_title',
            'text' => ['en' => 'Phone Number','en-CA' => 'Phone Number','en-AU' => 'Phone Number','en-GB'=> 'Phone Number'],
        ]);
        // 27
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'address_placeholder',
            'text' => ['en' => 'City of Residence (ex: Santa Rosa, California) or Zip/Postal Code',
                       'en-CA' => 'City of Residence (ex: Santa Rosa, California) or Zip/Postal Code',
                       'en-AU' => 'City of Residence (ex: Santa Rosa, California) or Zip/Postal Code',
                       'en-GB'=> 'City of Residence (ex: Santa Rosa, California) or Zip/Postal Code'],
        ]);
        // 28
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'how_did_you_hear_about_us',
            'text' => ['en' => 'How did you hear about us? Google, Friend, etc',
                       'en-CA' => 'How did you hear about us? Google, Friend, etc',
                       'en-AU' => 'How did you hear about us? Google, Friend, etc',
                       'en-GB'=> 'How did you hear about us? Google, Friend, etc'],
        ]);
        // 29
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'your_goal',
            'text' => ['en' => 'What is your goal for this camp?',
                       'en-CA' => 'What is your goal for this camp?',
                       'en-AU' => 'What is your goal for this camp?',
                       'en-GB'=> 'What is your goal for this camp?'],
        ]);
        // 30
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'anything_you_want_us_to_know',
            'text' => ['en' => 'Describe anything you want us to know!',
                       'en-CA' => 'Describe anything you want us to know!',
                       'en-AU' => 'Describe anything you want us to know!',
                       'en-GB'=> 'Describe anything you want us to know!'],
        ]);
        // 31 
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'close_button_title',
            'text' => ['en' => 'Close','en-CA' => 'Close','en-AU' => 'Close','en-GB'=> 'Close'],
        ]);
        // 32
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'submit_button_title',
            'text' => ['en' => 'Register','en-CA' => 'Register','en-AU' => 'Register','en-GB'=> 'Register'],
        ]);
        // 33
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'registration_loader_message',
            'text' => ['en' => 'Registering...','en-CA' => 'Registering...','en-AU' => 'Registering...','en-GB'=> 'Registering...'],
        ]);
        // 33
        LanguageLine::create([
            'group' => 'camps_prices_and_time',
            'key' => 'timezone_title',
            'text' => ['en' => 'timezone','en-CA' => 'timezone','en-AU' => 'timezone','en-GB'=> 'timezone'],
        ]);
    }
}
