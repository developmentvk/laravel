<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
     */

    'accepted' => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute may only contain letters.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'The :attribute must be a valid email address.',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file' => 'The :attribute may not be greater than :max kilobytes.',
        'string' => 'The :attribute may not be greater than :max characters.',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => 'The :attribute field is required.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute format is invalid.',
    'uuid' => 'The :attribute must be a valid UUID.',
    'success' => 'Successful.',
    'invalid_mobile_login_credentials' => 'Your mobile and/or password do not match.',
    'invalid_email_login_credentials' => 'Your email and/or password do not match.',
    'could_not_create_token' => 'Sorry! We are unable to generate token for you account.',
    'account_inactive' => 'Your account inactive',
    'account_blocked' => 'Your account blocked',
    'credential_verified' => 'You are loggedin successfully.',
    'otp_generated' => 'OTP Generated successfully.',
    'not_found_http_exception' => 'The requested resource could not be found but may be available again in the future. Subsequent requests by the client are permissible.',
    'jwt_invalid_claim_exception' => 'Invalid value provided for claim in JWT',
    'jwt_payload_factory' => 'The payload is immutable',
    'jwt_blacklisted' => 'The token has been blacklisted',
    'jwt_expired' => 'Token has expired and can no longer be refreshed',
    'jwt_invalid' => 'JWT payload does not contain the required claims',
    'jwt_user_not_defined_exception' => 'The token user not exist in our record.',
    'post_too_large_exception' => 'The server is refusing to process a request because the request entity is larger than the server is willing or able to process',
    'user_not_loggedin' => 'You are not logged in. Please log in and try again.',
    'session_expired' => 'Your authorization token is expired.',
    'otp_resent' => 'OTP Resent successfully.',
    'otp_verified' => 'You are loggedin successfully.',
    'invalid_otp' => 'You have entered invalid OTP.',
    'token_refreshed' => 'Your token renewed successfully.',
    'jwt_no_longer_refresh' => 'Your token expired. It can\'t be renewed.',
    'invalid_data' => 'The given data was invalid.',
    'unauthorized_access' => 'Unauthenticated.',
    'logged_out_successfully' => 'You have been successfully logged out!',
    'mobile_registered' => 'This mobile number is already registered.',
    'email_registered' => 'This email address is already registered.',
    'profile_updated' => 'Your information has been submitted successfully.',
    'file_uploading_failed' => 'Sorry! Unable to upload the file.',
    'password_changed' => 'Your password has been changed successfully!',
    'notification_deleted' => 'Notification deleted successfully.',
    'request_failed' => 'We are unable to process your request at this time.',
    'profile_setup_completed' => 'You have already set up your profile.',
    'username_available' => '<b>:attribute</b> is available.',
    'username_not_available' => '<b>:attribute</b> is unavailable.',
    'username_changed' => 'Your username has been changed successfully.',
    'privacy_updated' => 'Your privacy has been changed successfully.',
    'notification_preference_updated' => 'Your notification preference has been changed successfully.',
    'profile_cover_updated' => 'Your profile cover changed successfully.',
    'profile_image_updated' => 'Your image changed successfully.',
    'already_liked_post' => 'You are already liked.',
    'not_liked_post' => 'You are not liked.',
    'already_liked_post_comment' => 'You are already liked.',
    'not_liked_post_comment' => 'You are not liked.',
    'unprocessable_request' => 'Your request can\'t be processed.',
    'already_sent_invitation' => 'Your invitation already sent.',
    'already_accepted_invitation' => 'This user already in your friend list.',
    'invitation_sent' => 'Your invitation sent successfully.',
    'invitation_cancelled' => 'Your invitation cancelled successfully.',
    'invitation_accepted' => 'Your request processed successfully.',
    'invitation_rejected' => 'Invitation rejected successfully.',
    'unfriend_successful' => 'Your request processed successfully.',
    'already_following' => 'You are already in follower list of this user.',
    'following_successful' => 'Your request processed successfully.',
    'unfollow_successful' => 'Your request processed successfully.',
    'already_reported_post' => 'You are already reported.',
    'notification_deleted_successfully' => 'Notification deleted successfully',
    'password_recovery_instruction' => 'Your password recovery instruction sent your registered email.',
    'email_not_exist' => 'Invalid account information you are trying to recover.',
    'loggedin_successfully' => 'Credential Verified & Logged in successfully.',
    'navigation_created' => 'Navigation created successfully.',
    'navigation_updated' => 'Navigation updated successfully.',
    'navigation_deleted' => 'Navigation deleted successfully.',
    'admin_account_created' => 'Admin account created successfully',
    'admin_account_updated' => 'Admin account updated successfully',
    'admin_account_deleted' => 'Admin account deleted successfully',
    'new_password_updated' => 'New password updated successfully.',
    'permission_updated' => 'Permission updated successfully',
    'department_created' => 'Department created successfully',
    'department_updated' => 'Department updated successfully',
    'department_deleted' => 'Department deleted successfully',
    'user_account_created' => 'User account created successfully',
    'user_account_updated' => 'User account updated successfully',
    'user_account_deleted' => 'User account deleted successfully',
    'notification_saved' => 'Notification saved successfully',
    'notification_deleted' => 'Notification deleted successfully',
    'invalid_file_format' => 'Invalid file you are trying to upload',
    'invalid_locale' => 'Invalid locale',
    'invalid_device_type' => 'Invalid Device type',
    'invalid_device_id' => 'Invalid Device ID',
    'request_processed' => 'Request processed',
    'email_not_registered' => 'The email address you have entered it\'s not register with us.',
    'username_not_registered' => 'The username you have entered it\'s not register with us.',
    'mobile_not_registered' => 'The mobile number you have entered it\'s not register with us.',
    'invalid_username_login_credentials' => 'Your username and/or password do not match.',
    'recovery_email_not_exist' => 'Recovery email not registered with this account.',
    'no_record_found' => 'No record found',
    'password_recovery_method_not_updated' => 'Password recovery method not updated',
    'country_added' => 'Country added successfully.',
    'country_updated' => 'Country updated successfully.',
    'country_deleted' => 'Country deleted successfully.',
    'report_list_added' => 'Report List added successfully.',
    'report_list_updated' => 'Report List updated successfully.',
    'report_list_deleted' => 'Report List deleted successfully.',
    'setting_updated' => 'Setting updated successfully.',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
     */

    'custom' => [
        'username' => [
            'regex' => 'Your username must be 15 characters or less and contain only letters, numbers, and underscores and no spaces.',
        ],
        'video.*.directory' => [
            'required' => 'The video upload directory field is required.',
        ],
        'video.*.filename' => [
            'required' => 'The video filename field is required.',
        ],
        'video.*.thumb' => [
            'required' => 'The video thumb field is required.',
        ],
        'video.*.extension' => [
            'required' => 'The video extension field is required.',
        ],
        'video.*.mime_type' => [
            'required' => 'The video mime type field is required.',
        ],
        'video.*.duration' => [
            'required' => 'The video duration field is required.',
        ],
        'video.*.size' => [
            'required' => 'The video size field is required.',
        ],
        'video.*.display_order' => [
            'required' => 'The video display order field is required.',
            'numeric' => 'The video display order must be a number.',
            'min' => 'The video display order must be at least 0.',
        ],
        'image.*.directory' => [
            'required' => 'The image upload directory field is required.',
        ],
        'image.*.filename' => [
            'required' => 'The image filename field is required.',
        ],
        'image.*.extension' => [
            'required' => 'The image extension field is required.',
        ],
        'image.*.mime_type' => [
            'required' => 'The image mime type field is required.',
        ],
        'image.*.size' => [
            'required' => 'The image size field is required.',
        ],
        'image.*.display_order' => [
            'required' => 'The image display order field is required.',
            'numeric' => 'The image display order must be a number.',
            'min' => 'The image display order must be at least 0.',
        ],
        'youtube.*.url' => [
            'required' => 'The youtube url field is required.',
            'url' => 'The youtube url format like https://www.youtube.com/watch?v=laravel',
        ],
        'youtube.*.display_order' => [
            'required' => 'The youtube display order field is required.',
            'numeric' => 'The youtube display order must be a number.',
            'min' => 'The youtube display order must be at least 0.',
        ],
        'gif.*.url' => [
            'required' => 'The gif url field is required.',
            'url' => 'The gif url format like https://gph.is/g/ZORKVNP',
        ],
        'gif.*.display_order' => [
            'required' => 'The gif display order field is required.',
            'numeric' => 'The gif display order must be a number.',
            'min' => 'The gif display order must be at least 0.',
        ],
        'specific_friends.*' => [
            'required' => 'The specific friends field is required.',
        ],
        'friends_expect.*' => [
            'required' => 'The friends expect field is required.',
        ],
        'post_id' => [
            'exists' => 'This post is no longer available, it may have been removed.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
     */

    'attributes' => [
        'locale' => 'Locale',
        'device_type' => 'Device Type',
        'device_id' => 'Device ID',
    ],

];
