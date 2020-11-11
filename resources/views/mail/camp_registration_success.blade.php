Dear Customer, <br/><br/>
This email is to confirm the camp reservation for {{ $data['name'] }}.<br><br>

{{ $data['time'] }}<br/><br/>
Days:<ol>
        @foreach($data['listOfCamps'] as $camp )
            <li>{{ $camp->starts_at }}</li>
        @endforeach
    </ol>
Camp Location : {{ $data['address'] }}<br/><br/>

Student Name : {{ $data['name'] }}<br/>
Phone            : {{ $data['phone'] }}<br/>
Email            : {{ $data['email'] }}<br/>
Class Topic      : {{ $data['topic'] }}<br/>
Amount Paid      : US${{ $data['amount'] }}<br/>

<br/>
{{ $data['topic_based_instructions'] }}
<br/><br/>
To setup the student portal and access the Online Classroom, please login to https://portal.codewithus.com with the phone number {{ $data['phone'] }} provided during the registration. Please review the video below for step-by-step instructions:
https://www.youtube.com/watch?v=TnkmQePVD5U
<br/><br/>
Please check our FAQs <link: https://codewithus.com/faqs> for questions on technology requirements and pre-class readiness.

<br/><br/><br/>
If you have any questions, you can:<br/>
1. Respond to this email at info@codewithus.com<br/>
2. Text/Call us at (408) 909-7717<br/><br/>

We are getting ready and looking forward to having <Student Name> as our student. Thank you for signing up at Code With Us!!
<br/><br/>
Code With Us Team