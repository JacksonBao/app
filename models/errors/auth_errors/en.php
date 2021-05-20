
        <?php 
            
        /**
         * AUTH ERROR LIST
         */

        return [

                'authcitizen' => [
                        'invalid_contact' =>  'Invalid contact or password.',
                        'invalid_password' =>  'Invalid contact or password',
                        'invalid_user' => 'Invalid login details.',
                        'invalid_Content' => 'Fill in all the form data.'
                  ],
                  'authcitizenapplication' => [
                          'invalid_firstname' =>  'Firstname must be atleast 3 characters', 
                          'invalid_lastname' => 'Lastname must be atleast 3 characters',
                          'invalid_day' => 'Invalid birthday.',
                          'invalid_month' => 'Invalid birth month.',
                          'invalid_year' =>'Invalid birth year.',
                          'invalid_email' => 'Invalid email address',
                          'invalid_password' => 'Password must be at least 8 characters.',
                          'invalid_password2' => 'Password do not match.',
                          'invalid_gender' => 'Please enter a valid gender.',
                          'invalid_invalid_request' => 'Could not process your request at this time.',
                          'invalid_request' => 'Could not process your request. Please try again.'
                  ],
                   'usermessage' => [
                           'invalid_names' => 'Invalid names',
                           'invalid_email' => 'Invalid email address',
                           'invalid_subject' => 'Invalid message subject',
                           'invalid_message' => 'Invalid message',
                   ],
                   'generateapikey' => [
                           'invalid_user' => 'Sorry your session has expired. Please login to generate your API key.',
                           'create_success' => 'Congratulations your api key has been created successfully.',
                           'update_success' => 'Congratulations your api key has been updated successfully.',
                           'email_create_subject' =>  '[API KEY] Congratulations your Thanos Key is active.',
                           'email_create_body' => 'You Thanosapi key is now live. <h4>{{ apikey }}</h4> <br> You have access to all Stones. <br> <b>Login to your account to setup domains.</b>',
                           'email_update_subject' => '[API KEY] Your Thanosapi access key has been changed.',
                           'email_update_body' =>  'You Thanosapi key is now live. <h4>{{ apikey }}</h4> <br> You will have to replace your access key on all your applications to be able to access thanosapi stones.',
                   ],

                   'removeapidomain' => [
                           'success' => 'Domain has been succesfully remove.',
                           'invalid_access' => 'You do not have permission to delete this domain',
                           'invalid_id' => 'Invalid site id.'
                   ],
                   'addapidomain' => [
                           'invalid_user' => 'You must be logged in to add domain.',
                           'invalid_domain' => 'Sorry this domain has already been registered for this api route',
                           'success' => 'Domain added successfully.'
                   ],
                   'runendpoint' => [
                           'invalid_endpoint' => 'The endpoint you provided is invalid.',
                           'invalid_method' => 'Invalid api method.'
                   ]

        ];
        
      