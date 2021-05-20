
        <?php 
            
        /**
         * API ERROR LIST
         */

        return [
                'authenticate' => [
                        'invalid' => 'Sorry this method is not yet available for use.',
                        'invalid_type' => 'Invalid request type. Submited {requested} instead of {submited}',
                        'invalid_user' => 'Invalid api access token. Your account has been deleted/suspended',
                        'missing_key' => 'The api key you provided is incorrect.',
                        'invalid_host' => '{host} is not registered to your api account.',
                        'invalid_throttle' => 'Request throttled. You have reached the maximum quota {quota} request(s). Restore date {restore}'
                ]
        ];
        
      