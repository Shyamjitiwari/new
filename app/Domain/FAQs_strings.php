<?php

namespace App\Domain;
use App\LanguageLine;

class FAQs_strings
{
    public static function add_faqs_strings_into_database(){
        // 1
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'code_with_us',
            'text' => ['en' => 'Code With Us'],
        ]);
        // 2
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'detail_about_code_with_us',
            'text' => ['en' => 'Details about Code With Us.'],
        ]);
        // 3
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'faqs_page_title',
            'text' => ['en' => 'FAQs'],
        ]);
        // 4
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'about_cwu_question',
            'text' => ['en' => 'About Code With Us'],
        ]);
        // 5
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'about_cwu_answer',
            'text' => ['en' => 'Code With Us is a venture-backed technology education organization founded in 2016 in Silicon Valley, CA. We teach students a variety of skills through coding education that include popular programming languages, robotics, virtual reality, 3D printing, creative game design and much more. Our students actively participate and have won many coding competitions. We are the first organization in California to provide customized coding curriculum for schools. Currently we are teaching approximately 2600 students.'],
        ]);
        // 6
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'location_of_classes_question',
            'text' => ['en' => 'Where are the classes located?'],
        ]);
        // 7
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'location_of_classes_answer',
            'text' => ['en' => 'We offer classes at 8 locations in the SF Bay area and New York. Most of our classes are in-person in small class size setup. We also offer online classes, which is getting popular with students that require flexibility. 
            We also teach students in 40+ school campuses across the Bay Area, that include after school programs and in-curriculum graded classes. '],
        ]);
        // 8
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'classes_offered_by_cwu_question',
            'text' => ['en' => 'What classes does Code With Us offer?'],
        ]);
        // 9
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'classes_offered_by_cwu_answer',
            'text' => ['en' => 'We offer classes in 15+ coding languages and design thinking. Students can select the type of projects they want to create and we recommend the language based on their skill level and interests. 
            Some of our popular topics are:<br/>
            <ul>
            <li>Game Design with Scratch</li>
            <li>Application Development with Python</li>
            <li>Web Development with JavaScript</li>
            <li>Build and Design Robots and Gadgets with Arduino and C++</li>
            <li>Virtual Reality Design with Unity</li>
            </ul>'],
        ]);
        // 10
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'teaching_methods_at_cwu_question',
            'text' => ['en' => 'What is the teaching method at Code With Us?'],
        ]);
        // 11
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'teaching_methods_at_cwu_answer',
            'text' => ['en' => 'We believe in giving personalized attention to each student and implement project-based learning. Not everyone learns at the same pace or with the same style. We have developed customized curricula that our teachers use to provide step-by-step instructions to create games and projects in the coding language of students’ interests. Our teachers explain coding fundamentals while working on the projects. We have noticed this method to be an excellent way to enhance students’ learning experiences and to keep them engaged.'],
        ]); 
        // 12
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'who_are_teachers_question',
            'text' => ['en' => 'Who are the teachers at Code With Us?'],
        ]);
        // 13
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'who_are_teachers_answer',
            'text' => ['en' => 'Our teachers are Computer Science graduates and students from local universities, and they are based in the United States. They are thoroughly vetted for their coding skills and teaching ability. We hold regular training for our teachers to improve their skillset. Our teachers go through background checks before joining Code With Us.'],
        ]);
        // 14
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'billing_policy',
            'text' => ['en' => 'Billing Policy'],
        ]);
        // 15
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'sub_heading_billing_policy',
            'text' => ['en' => 'Issues related to payments.'],
        ]);
        // 16
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'class_and_price_options',
            'text' => ['en' => 'What are the class and price options?'],
        ]);
        // 17
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'small_group_class_label',
            'text' => ['en' => 'Small Group Class'],
        ]);
        // 18
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'private_class_label',
            'text' => ['en' => 'Private Class'],
        ]);
        // 19
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'weekly_camps_label',
            'text' => ['en' => 'Weekly Camps'],
        ]);
        // 20
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'small_group_class_details',
            'text' => ['en' => '<ul>
                                <li>3 students to 1 teacher</li>
                                <li>In-person or Online</li>
                                <li>Starting at $37/class</li>
                                </ul>',
                        'en-GB' => '<ul>
                                <li>3 students to 1 teacher</li>
                                <li>In-person or Online</li>
                                <li>Starting at £30/class</li>
                                </ul>',
                        'en-AU' => '<ul>
                                <li>3 students to 1 teacher</li>
                                <li>In-person or Online</li>
                                <li>Starting at AU$54/class</li>
                                </ul>'
                        ],
        ]);
        // 21
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'private_class_details',
            'text' => ['en' => '<ul>
                                <li>1 student to 1 teacher</li>
                                <li>In-person or Online</li>
                                <li>Starting at $60/class</li>
                                </ul>',
                        'en-GB' => '<ul>
                                <li>1 student to 1 teacher</li>
                                <li>In-person or Online</li>
                                <li>Starting at £48/class</li>
                                </ul>',
                        'en-AU' => '<ul>
                                <li>1 student to 1 teacher</li>
                                <li>In-person or Online</li>
                                <li>Starting at AU$87/class</li>
                                </ul>'
                    ],
        ]);
        // 22
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'weekly_camps_details',
            'text' => ['en' => '<ul>
                                <li>6 students to 1 teacher</li>
                                <li>In-person or Online</li>
                                <li>Starting at $295/camp</li>
                                </ul>',
                        'en-GB' => '<ul>
                                <li>6 students to 1 teacher</li>
                                <li>In-person or Online</li>
                                <li>Starting at £237/camp</li>
                                </ul>',
                        'en-AU' => '<ul>
                                <li>6 students to 1 teacher</li>
                                <li>In-person or Online</li>
                                <li>Starting at AU$430/camp</li>
                                </ul>'
                    ],
        ]);
        // 23
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'note_for_prices_of_classess',
            'text' => ['en' => '*Current price, subject to change based on market condition and location.'],
        ]);
        // 24
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'trying_a_class_before_signup_question',
            'text' => ['en' => 'Can we try out a class before signing up?'],
        ]);
        // 25
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'trying_a_class_before_signup_answer',
            'text' => ['en' => 'Absolutely yes! You are welcome to sign-up for a free 1-hour introductory coding lesson before signing up. Besides assessing Code With Us, you also need to ensure that students are interested and enjoying the class and we are the right fit for their needs.'],
        ]);
        // 26
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'classes_heading',
            'text' => ['en' => 'Classes'],
        ]);
        // 27
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'classes_sub_heading',
            'text' => ['en' => 'Questions related to Classes at CodeWithUs'],
        ]);
        // 28
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'deciding_the_level_and_topic_for_students_question',
            'text' => ['en' => 'How do I decide the right topic and level for my student?'],
        ]);
        // 29
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'deciding_the_level_and_topic_for_students_answer',
            'text' => ['en' => 'We begin with evaluating students’ prior experience and projects they’re interested in during the first class. After our initial assessment, we recommend topics and levels that match their objectives and keep them interested in learning. Assigning students at the right level is important for their long-term success. As we progress with classes, based on a student’s learning pace and ability, we realign our lesson plans.'],
        ]);
        // 30
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'staying_upto_date_with_students_progress_question',
            'text' => ['en' => 'How do I stay up to date with a student’s progress?'],
        ]);
        // 31
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'staying_upto_date_with_students_progress_answer',
            'text' => ['en' => 'We have designed a proprietary LMS (Learning Management System) to track students’ progress and receive updates from students. Students and parents can log in to a portal to check progress, review projects, check billing and schedule and communicate with teachers.'],
        ]); 
        // 32  
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'student_work_can_be_reviewed_question',
            'text' => ['en' => 'Can we review student’s work from home?'],
        ]);  
        // 33
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'student_work_can_be_reviewed_answer',
            'text' => ['en' => 'Yes! You can access all the assignments and projects in the student portal. Everything is hosted in the cloud so students can access from anywhere.'],
        ]);  
        // 34    
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'in_person_class_look_like_question',
            'text' => ['en' => 'What does a typical In-person class look like?'],
        ]);  
        // 35
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'in_person_class_look_like_answer',
            'text' => ['en' => 'Our in-person classes are scheduled, students meet with their teacher at a recurring time each week. When a student arrives in the classroom, he/she is allocated a computer to work on the project. The assigned teacher always stays with the student to answer and explain lessons. A teacher always reviews completed work and frequently challenges student to think outside the box to make design improvements.'],
        ]);  
        // 36
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'online_class_looklike_question',
            'text' => ['en' => 'What does a typical Online class look like?'],
        ]);
        // 37
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'online_class_looklike_answer',
            'text' => ['en' => 'A student logs in to the portal to access the individual online classroom, students meet with their teacher at a recurring time each week. The Student needs a computer with a microphone and speaker (camera optional) along with internet connection. Teacher views student’s screen and guides them to work on the project. Online portal is very interactive, and teachers maintain constant communication with students to keep them engaged.'],
        ]);
        // 38
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'technical_requirement_for_online_class_question',
            'text' => ['en' => 'What is the technology requirement for an Online class?'],
        ]);
        // 39
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'technical_requirement_for_online_class_answer',
            'text' => ['en' => '<ol>
            <li>A desktop or laptop, with a microphone and speaker, camera is optional.</li>
            <li>A working mouse for efficient browsing.</li>
            <li>An updated web browser (Example; Chrome, FireFox, Safari).</li> 
            <li>High-speed internet connection.</li>
            <li>Headphones are recommended to allow the student to effectively communicate with the teacher in the online classroom.</li>
            </ol>'],
        ]);
        // 40
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'security_heading',
            'text' => ['en' => 'Security'],
        ]);
        // 41
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'security_sub_heading',
            'text' => ['en' => 'Questions related to Security'],
        ]);
        // 42
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'cwu_addresses_security_concern_question',
            'text' => ['en' => 'How does Code With Us address Online security concern?'],
        ]);
        // 43
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'cwu_addresses_security_concern_answer',
            'text' => ['en' => 'We take online security very seriously. We use Google Meet platform for online classes and have implemented layers of security to protect online classrooms. 
            <ol>
            <li>Student has to log in to a password protected individual portal</li>
            <li>Online classroom ID is unique for each student</li>
            <li>Only a teacher can allow someone to access an online classroom</li>
            <li>All online sessions are encrypted.</li>
            </ol>'],
        ]);
        // 44
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'read_on_security_label',
            'text' => ['en' => 'Read more on the security: '],
        ]);
        // 45
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'read_on_security_link',
            'text' => ['en' => 'https://cloud.google.com/blog/products/g-suite/how-google-meet-keeps-video-conferences-secure'],
        ]);
        // 46
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'long_term_commitment_with_cwu_question',
            'text' => ['en' => 'Is there any long-term commitment with Code With Us?'],
        ]);
        // 47
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'long_term_commitment_with_cwu_answer',
            'text' => ['en' => 'We believe in utmost transparency and flexibility. There’s no long-term commitment with Code With Us, you can cancel your lesson plan anytime with a month’s notice. '],
        ]);
        // 48
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'class_reschedule_policy_question',
            'text' => ['en' => 'What is your class reschedule policy?'],
        ]);
        // 49
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'class_reschedule_policy_answer',
            'text' => ['en' => 'We schedule and assign resources for our classes weekly. We expect at least 48-hour notice to reschedule a class.'],
        ]);
        // 50
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'refund_policy_on_camps_question',
            'text' => ['en' => 'What is your refund policy for camps?'],
        ]);
        // 51
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'refund_policy_on_camps_answer',
            'text' => ['en' => 'We have to schedule and commit appropriate resources in advance for camps. Following is our refund policy:
                <ul>
                <li>100% refund 7 days prior to the beginning of the camp</li>
                <li>50% refund 24 hours prior to the beginning of the camp</li>
                </ul>'],
        ]);
        // 52
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'siblings_discount_question',
            'text' => ['en' => 'Does Code With Us provide any sibling discount?'],
        ]);
        // 53
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'siblings_discount_answer',
            'text' => ['en' => 'Yes we offer sibling discount. For each registered sibling we offer 10% discount on their regular monthly fee.'],
        ]);
        // 54
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'reviews_heading',
            'text' => ['en' => 'Reviews'],
        ]);
        // 55
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'reviews_sub_heading',
            'text' => ['en' => 'Reviews From Customers'],
        ]);
        // 56
        LanguageLine::create([
            'group' => 'FAQs',
            'key' => 'yelp_review_question',
            'text' => ['en' => 'What are the reviews from customers?'],
        ]);
    }
    public static function addFAQsTranslationsForCanadianLocale(){
        // 1
        $language = LanguageLine::where(['key' => 'code_with_us', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 2
        $language = LanguageLine::where(['key' => 'detail_about_code_with_us', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 3
        $language = LanguageLine::where(['key' => 'faqs_page_title', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 4
        $language = LanguageLine::where(['key' => 'about_cwu_question', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 5
        $language = LanguageLine::where(['key' => 'about_cwu_answer', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 6
        $language = LanguageLine::where(['key' => 'location_of_classes_question', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 7
        $language = LanguageLine::where(['key' => 'location_of_classes_answer', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 8
        $language = LanguageLine::where(['key' => 'classes_offered_by_cwu_question', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 9
        $language = LanguageLine::where(['key' => 'classes_offered_by_cwu_answer', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 10
        $language = LanguageLine::where(['key' => 'teaching_methods_at_cwu_question', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 11
        $language = LanguageLine::where(['key' => 'teaching_methods_at_cwu_answer', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 12
        $language = LanguageLine::where(['key' => 'who_are_teachers_question', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 13
        $language = LanguageLine::where(['key' => 'who_are_teachers_answer', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 14
        $language = LanguageLine::where(['key' => 'billing_policy', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 15
        $language = LanguageLine::where(['key' => 'sub_heading_billing_policy', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 16
        $language = LanguageLine::where(['key' => 'class_and_price_options', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 17
        $language = LanguageLine::where(['key' => 'small_group_class_label', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 18
        $language = LanguageLine::where(['key' => 'private_class_label', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 19
        $language = LanguageLine::where(['key' => 'weekly_camps_label', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 20
        $language = LanguageLine::where(['key' => 'small_group_class_details', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => '<ul>
                                                        <li>3 students to 1 teacher</li>
                                                        <li>In-person or Online</li>
                                                        <li>Starting at C$50/class</li>
                                                        </ul>');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 21
        $language = LanguageLine::where(['key' => 'private_class_details', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => '<ul>
                                                        <li>1 student to 1 teacher</li>
                                                        <li>In-person or Online</li>
                                                        <li>Starting at C$81/class</li>
                                                        </ul>');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 22
        $language = LanguageLine::where(['key' => 'weekly_camps_details', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => '<ul>
                                                        <li>6 students to 1 teacher</li>
                                                        <li>In-person or Online</li>
                                                        <li>Starting at C$400/camp</li>
                                                        </ul>');
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 23
        $language = LanguageLine::where(['key' => 'note_for_prices_of_classess', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 24
        $language = LanguageLine::where(['key' => 'trying_a_class_before_signup_question', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 25
        $language = LanguageLine::where(['key' => 'trying_a_class_before_signup_answer', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 26
        $language = LanguageLine::where(['key' => 'classes_heading', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 27
        $language = LanguageLine::where(['key' => 'classes_sub_heading', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 28
        $language = LanguageLine::where(['key' => 'deciding_the_level_and_topic_for_students_question', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 29
        $language = LanguageLine::where(['key' => 'deciding_the_level_and_topic_for_students_answer', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 30
        $language = LanguageLine::where(['key' => 'staying_upto_date_with_students_progress_question', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 31
        $language = LanguageLine::where(['key' => 'staying_upto_date_with_students_progress_answer', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 32
        $language = LanguageLine::where(['key' => 'student_work_can_be_reviewed_question', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 33
        $language = LanguageLine::where(['key' => 'student_work_can_be_reviewed_answer', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 34
        $language = LanguageLine::where(['key' => 'in_person_class_look_like_question', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 35
        $language = LanguageLine::where(['key' => 'in_person_class_look_like_answer', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 36
        $language = LanguageLine::where(['key' => 'online_class_looklike_question', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 37
        $language = LanguageLine::where(['key' => 'online_class_looklike_answer', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 38
        $language = LanguageLine::where(['key' => 'technical_requirement_for_online_class_question', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 39
        $language = LanguageLine::where(['key' => 'technical_requirement_for_online_class_answer', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 40
        $language = LanguageLine::where(['key' => 'security_heading', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 41
        $language = LanguageLine::where(['key' => 'security_sub_heading', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 42
        $language = LanguageLine::where(['key' => 'cwu_addresses_security_concern_question', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 43
        $language = LanguageLine::where(['key' => 'cwu_addresses_security_concern_answer', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 44
        $language = LanguageLine::where(['key' => 'read_on_security_label', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 45
        $language = LanguageLine::where(['key' => 'read_on_security_link', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 46
        $language = LanguageLine::where(['key' => 'long_term_commitment_with_cwu_question', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 47
        $language = LanguageLine::where(['key' => 'long_term_commitment_with_cwu_answer', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 48
        $language = LanguageLine::where(['key' => 'class_reschedule_policy_question', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 49
        $language = LanguageLine::where(['key' => 'class_reschedule_policy_answer', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 50
        $language = LanguageLine::where(['key' => 'refund_policy_on_camps_question', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 51
        $language = LanguageLine::where(['key' => 'refund_policy_on_camps_answer', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 52
        $language = LanguageLine::where(['key' => 'siblings_discount_question', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 53
        $language = LanguageLine::where(['key' => 'siblings_discount_answer', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 54
        $language = LanguageLine::where(['key' => 'reviews_heading', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 55
        $language = LanguageLine::where(['key' => 'reviews_sub_heading', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();

        // 56
        $language = LanguageLine::where(['key' => 'yelp_review_question', 'group' => 'FAQs'])->first();
        $new_locale_and_translation = array('en-CA' => $language->text['en']);
        $updated_text =array_merge($language->text, $new_locale_and_translation);
        $language->text = $updated_text;
        $language->save();
    }
}