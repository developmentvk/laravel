<?php

if (!function_exists('getYoutubeId')) {
    function getYoutubeId($url)
    {
        // Here is a sample of the URLs this regex matches: (there can be more content after the given URL that will be ignored)

        // http://youtu.be/dQw4w9WgXcQ
        // http://www.youtube.com/embed/dQw4w9WgXcQ
        // http://www.youtube.com/watch?v=dQw4w9WgXcQ
        // http://www.youtube.com/?v=dQw4w9WgXcQ
        // http://www.youtube.com/v/dQw4w9WgXcQ
        // http://www.youtube.com/e/dQw4w9WgXcQ
        // http://www.youtube.com/user/username#p/u/11/dQw4w9WgXcQ
        // http://www.youtube.com/sandalsResorts#p/c/54B8C800269D7C1B/0/dQw4w9WgXcQ
        // http://www.youtube.com/watch?feature=player_embedded&v=dQw4w9WgXcQ
        // http://www.youtube.com/?feature=player_embedded&v=dQw4w9WgXcQ

        // It also works on the youtube-nocookie.com URL with the same above options.
        // It will also pull the ID from the URL in an embed code (both iframe and object tags)

        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        return $match[1];
    }
}

if (!function_exists('getYoutubeData')) {
    function getYoutubeData($url)
    {
        $videoId = getYoutubeId($url);

        $apikey = "AIzaSyDdLuZfT2E1-4WlzCReuizWwDegz86WWNc";
        $googleApiUrl = 'https://www.googleapis.com/youtube/v3/videos?id=' . $videoId . '&key=' . $apikey . '&part=snippet';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);

        curl_close($ch);

        $data = json_decode($response);

        $value = json_decode(json_encode($data), true);

        $title = $value['items'][0]['snippet']['title'];
        $description = $value['items'][0]['snippet']['description'];
        return $value;
    }
}

if (!function_exists('fetchUserFriends')) {
    function fetchUserFriends($id)
    {
        // \Cache::forget("fetchUserFriends{$id}");
        return \Cache::rememberForever("fetchUserFriends{$id}", function () use ($id) {
            $output = [];
            $friends = \App\Models\Friends::select(['from_user_id', 'to_user_id'])->where('from_user_id', $id)->orWhere('to_user_id', $id)->get();
            if ($friends->isNotEmpty()) {
                foreach ($friends as $row) {
                    if ($row->from_user_id != $id) {
                        $output[] = $row->from_user_id;
                    }
                    if ($row->to_user_id != $id) {
                        $output[] = $row->to_user_id;
                    }
                }
            }
            $output = array_unique($output);
            return $output;
        });
    }
}

if (!function_exists('fetchUserFollowers')) {
    function fetchUserFollowers($id)
    {
        // \Cache::forget("fetchUserFollowers{$id}");
        return \Cache::rememberForever("fetchUserFollowers{$id}", function () use ($id) {
            return \App\Models\Follower::where('following_id', $id)->pluck('follower_id')->toArray();
        });
    }
}

if (!function_exists('extractHashTag')) {
    function extractHashTag($hashtagData = null)
    {
        $output = array();
        if ($hashtagData != null) {
            preg_match_all("/#(\\w+)/", $hashtagData->message, $matches);
            if (count($matches[0])) {
                foreach ($matches[0] as $hashtag) {
                    $hashtag = trim($hashtag);
                    $tagResponse = \App\Models\Hashtag::where(['hashtag' => $hashtag, 'is_deleted' => 0])->first();
                    if ($tagResponse) {
                        $tagResponse->views = $tagResponse->views + 1;
                        $tagResponse->save();

                        $output[$tagResponse->id] = $hashtag;
                    } else {
                        $hashTags = new \App\Models\Hashtag();
                        $hashTags->user_id = $hashtagData->user_id;
                        $hashTags->post_id = $hashtagData->post_id;
                        $hashTags->post_comment_id = $hashtagData->post_comment_id;
                        $hashTags->ip_address = $hashtagData->ip_address;
                        $hashTags->locale = $hashtagData->locale;
                        $hashTags->source = $hashtagData->source;
                        $hashTags->views = 1;
                        $hashTags->hashtag = $hashtag;
                        $hashTags->save();

                        $output[$hashTags->id] = $hashtag;
                    }
                }
            }
        }
        return $output;
    }
}

if (!function_exists('validateUsername')) {
    function validateUsername($username)
    {
        return preg_match('/^[A-Za-z0-9_]+$/', $username);
    }
}

if (!function_exists('generateUsername')) {
    function generateUsername($username = null, $id = false)
    {
        $username = explode("@", $username);
        $username = $username[0];
        $username = explode(" ", $username);
        // produce a username based on the activity username
        $username = \Str::slug($username[0]);
        // check to see if any other slugs exist that are the same & count them
        $count = \App\Models\User::whereRaw("username RLIKE '^{$username}(_[0-9]+)?$'")->where(function ($where) use ($id) {
            if ($id) {
                $where->where("id", '!=', $id);
            }
        })->count();
        // if other username exist that are the same, append the count to the username
        $username = $count ? "{$username}_{$count}" : $username;
        return $username;
    }
}

if (!function_exists('calculateAvgRating')) {
    function calculateAvgRating($total_rating = 0, $total_rated = 0)
    {
        return ($total_rating) ? round($total_rating / $total_rated) : 0;
    }
}

if (!function_exists('checkMatched')) {
    function checkMatched($number1, $number2)
    {
        if ($number2 > 0) {
            $totalNumber = ($number1 - $number2);
            return $totalNumber ? (abs($totalNumber / $number2) < 0.00001) : true;
        }
        return ((double) $number1 == (double) $number2);
    }
}

if (!function_exists('calculatePercentageAmount')) {
    function calculatePercentageAmount($amount = 0, $vat = 0)
    {
        return $vat ? round(($amount * ($vat / 100)), 2) : 0;
    }
}
if (!function_exists('errorMessage')) {
    function errorMessage($template = '', $string = false, $object = [], $httpCode = false)
    {
        $message = $string == true ? $template : __("validation.{$template}", $object);
        if ($httpCode == 401) {
            throw new \Tymon\JWTAuth\Exceptions\JWTException($message);
        }
        $validator = \Validator::make([], []); // Empty data and rules fields
        $validator->errors()->add('error', $message);
        throw new \Illuminate\Validation\ValidationException($validator);
    }
}

if (!function_exists('successMessage')) {
    function successMessage($template = '', $httpCode = 200, $dataArr = null, $object = [])
    {
        $output = new \stdClass;
        $output->message = __("validation.{$template}", $object);
        $output->data = $dataArr;
        return response()->json($output, $httpCode);
    }
}

if (!function_exists('arrayFromPost')) {
    function arrayFromPost($fieldArr = [])
    {
        try {
            $request = request();

            $output = new \stdClass;
            foreach (array_merge(['locale', 'device_type', 'device_id'], $fieldArr) as $value) {
                $output->$value = $request->input($value);
            }
            if (!@$request->locale) {
                $output->locale = \App::getLocale();
            }
            $output->ql = $request->locale == 'en' ? 'en_' : '';
            return $output;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

if (!function_exists('detectUserIpAddress')) {
    function detectUserIpAddress()
    {
        if (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && $_SERVER['HTTP_CF_CONNECTING_IP']) {
            return $_SERVER['HTTP_CF_CONNECTING_IP'];
        }
        return \Request::getClientIp();
    }
}

if (!function_exists('storeFCMData')) {
    function storeFCMData($dataArr, $user_id)
    {
        $userFcmTokens = \App\Models\UserFcmTokens::where(['device_id' => $dataArr->device_id])->first();
        if (!$userFcmTokens) {
            $userFcmTokens = new \App\Models\UserFcmTokens();
        }
        if ($user_id) {
            $userFcmTokens->user_id = $user_id;
        }
        $userFcmTokens->fcm_id = $dataArr->fcm_id;
        $userFcmTokens->device_id = $dataArr->device_id;
        $userFcmTokens->device_type = $dataArr->device_type;
        $userFcmTokens->save();
        return true;
    }
}

if (!function_exists('generateToken')) {
    function generateToken($request, $dataArr, $tokenUser)
    {
        try {
            \DB::beginTransaction();
            $userLoginLogs = new \App\Models\UserLoginLogs();
            $userLoginLogs->user_id = $tokenUser->id;
            $userLoginLogs->device_id = $dataArr->device_id;
            $userLoginLogs->device_type = $dataArr->device_type;
            $userLoginLogs->login_at = \Carbon::now()->toDateTimeString();
            $userLoginLogs->ip_address = detectUserIpAddress();
            $userLoginLogs->browser = $request->server('HTTP_USER_AGENT');
            $userLoginLogs->save();
            if ($userLoginLogs->user_id) {
                $tokenUser->login_log_id = $userLoginLogs->id;
            }

            storeFCMData($dataArr, $tokenUser->id);

            $output = new \stdClass;
            $output->access_token = \JWTAuth::fromUser($tokenUser);
            $output->token_type = 'bearer';
            $output->expires_in = \JWTAuth::factory()->getTTL() * 60; // In Seconds
            $output->expires_unit = 'Seconds';

            $tokenUser->last_token = $output->access_token;
            $tokenUser->save();

            unset($tokenUser->login_log_id, $tokenUser->updated_at, $tokenUser->status, $tokenUser->otp, $tokenUser->posts, $tokenUser->comments, $tokenUser->likes, $tokenUser->shares, $tokenUser->reports, $tokenUser->is_deleted, $tokenUser->deleted_at, $tokenUser->views, $tokenUser->blocked, $tokenUser->last_token);
            $output->data = $tokenUser;
            \DB::commit();
            return $output;
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            errorMessage($e->errorInfo[2], true);
        }
    }
}

if (!function_exists('triggerOtpToUsers')) {
    function triggerOtpToUsers($dataArr)
    {
        if (@$dataArr->send_email) {
            $options = [
                'title' => $dataArr->title,
                'body' => $dataArr->message,
            ];
            // dd($options);
            return sendEmail($dataArr->email, "{$dataArr->locale}.otp", $options, $dataArr->title);
        } else {
            return triggerNotificationToUsers($dataArr, $dataArr->user_id);
        }

    }
}

if (!function_exists('triggerEmailToUsers')) {
    function triggerEmailToUsers($options)
    {
        return sendEmail($options->email, $options->template, (array) $options, $options->subject);
    }
}

if (!function_exists('triggerNotificationToUsers')) {
    function triggerNotificationToUsers($dataArr = null, $user_id)
    {
        // dd($dataArr);
        $output = array();
        $adminIdArr = is_array($user_id) ? $user_id : [$user_id];
        if ($dataArr != null && count($adminIdArr)) {
            $adminData = \App\Models\UserFcmTokens::whereIn('user_id', $adminIdArr)->pluck('fcm_id')->toArray();
            $fcmDataArr = array();
            $fcmDataArr['title'] = $dataArr->title;
            $fcmDataArr['body'] = $dataArr->message;
            $fcmDataArr['extraData'] = $dataArr;
            if (count($adminData)) {
                $output[] = sendPushNotification($adminData, $fcmDataArr);
            }
        }
        return $output;
    }
}

if (!function_exists('deleteFCMToken')) {
    function deleteFCMToken($device_id = false)
    {
        if ($device_id) {
            return \App\Models\UserFcmTokens::where(['device_id' => $device_id])->delete();
        }
        return false;
    }
}

if (!function_exists('sendPushNotification')) {
    function sendPushNotification($fcm_id = array(), $dataArr = array())
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $api_key = config('app.LegacyServerKey');
        $notificationArr = array();
        $notificationArr['title'] = $dataArr['title'];
        $notificationArr['body'] = $dataArr['body'];
        $notificationArr['sound'] = "default";
        $extraData = new \stdClass;
        if (isset($dataArr['extraData'])) {
            $extraData = $dataArr['extraData'];
        }
        $arrayToSend = array();
        $arrayToSend['registration_ids'] = is_array($fcm_id) ? $fcm_id : [$fcm_id];
        $arrayToSend['priority'] = "high";
        $arrayToSend['content_available'] = true;
        $arrayToSend['data'] = array(
            'title' => $notificationArr['title'],
            'body' => $notificationArr['body'],
            'extraData' => $extraData,
        );
        $headers = [
            "Content-Type:application/json",
            "Authorization:key={$api_key}",
        ];
        \Log::info('FCM Push Notification', $arrayToSend);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayToSend));
        $result = curl_exec($ch);
        if ($result === false) {
            $result = curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }
}

if (!function_exists('storeNotification')) {

    function storeNotification($message = null)
    {
        try {
            if ($message != null) {
                $notification = new \App\Models\Notifications();
                $notification->notification_type = $message->notify_type;
                $notification->title = $message->title;
                $notification->en_title = $message->en_title;
                $notification->message = $message->message;
                $notification->en_message = $message->en_message;
                $notification->attribute = $message->attribute;
                $notification->value = $message->value;
                $notification->save();

                $userNotifications = new \App\Models\UserNotifications();
                $userNotifications->notification_id = $notification->id;
                $toIdArr = is_array($message->to_id) ? $message->to_id : [$message->to_id];
                if (count($toIdArr)) {
                    foreach ($toIdArr as $to_id) {
                        $userNotifications->user_id = $to_id;
                    }
                }
                $userNotifications->save();
                return $userNotifications;
            }
        } catch (\Exception $e) {
            return $e;
        }
    }
}

if (!function_exists('sendEmail')) {

    function sendEmail($to, $template, $data, $subject, $attachments = [])
    {
        try {
            return \Mail::send("emails.{$template}", $data, function ($message) use ($to, $subject, $attachments) {
                $message->subject($subject)->to($to);
                // ->bcc('development.vk@hotmail.com');
                if (count($attachments) > 0) {
                    foreach ($attachments as $attachment) {
                        $message->attachData($attachment['file'], $attachment['name']);
                    }
                }
            });
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
}

if (!function_exists('generateOTP')) {
    function generateOTP($digits = 4)
    {
        return rand(pow(10, $digits - 1), pow(10, $digits) - 1);
    }
}

if (!function_exists('hashToken')) {
    function hashToken()
    {
        return md5(uniqid(rand(), true));
    }
}

if (!function_exists('decodeTimestamp')) {
    function decodeTimestamp($timestamp)
    {
        return \Carbon::createFromTimeStamp(strtotime($timestamp))->diffForHumans();
    }
}

if (!function_exists('diffInMinutes')) {
    function diffInMinutes($start_time, $stop_time, $days = false)
    {
        $startTime = \Carbon::parse(date('Y-m-d H:i:s', strtotime($start_time)));
        $finishTime = \Carbon::parse(date('Y-m-d H:i:s', strtotime($stop_time)));
        if ($days) {
            return $finishTime->diffInDays($startTime);
        } else {
            return $finishTime->diffInMinutes($startTime);
        }
    }
}
if (!function_exists('numberFormatShort')) {
    function numberFormatShort($n, $precision = 1)
    {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }
        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ($precision > 0) {
            $dotzero = '.' . str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
        }
        return $n_format . $suffix;
    }
}

if (!function_exists('formatTimestamp')) {
    function formatTimestamp($timestamp, $format = 'd M, Y h:i A')
    {
        return \Carbon::parse($timestamp)->format($format);
    }
}

if (!function_exists('parseToken')) {
    function parseToken($forceCheck = false, $ignore = false)
    {
        try {
            $tokenUser = collect([]);
            $tokenUser->id = null;
            $token = \JWTAuth::getToken();
            if ($token && $ignore == false) {
                $tokenUser = auth('api')->setToken($token)->user();
                if (!$tokenUser) {
                    throw new \Tymon\JWTAuth\Exceptions\TokenInvalidException(__('validation.user_not_loggedin'));
                }
            } elseif ($forceCheck) {
                throw new \Tymon\JWTAuth\Exceptions\TokenInvalidException(__('validation.user_not_loggedin'));
            }
            return $tokenUser;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 6, $characters = 'upper_case,numbers')
    {
        // $length - the length of the generated password
        // $count - number of passwords to be generated
        // $characters - types of characters to be used in the password
        // define variables used within the function
        $symbols = array();
        $passwords = array();
        $used_symbols = '';
        $pass = '';
        // an array of different character types
        $symbols['lower_case'] = 'abcdefghijklmnopqrstuvwxyz';
        $symbols['upper_case'] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $symbols['numbers'] = '1234567890';
        $symbols['special_symbols'] = '!?~@#-_+<>[]{}';
        $characters = explode(',', $characters); // get characters types to be used for the password
        foreach ($characters as $key => $value) {
            $used_symbols .= $symbols[$value]; // build a string with all characters
        }
        $symbols_length = strlen($used_symbols) - 1; //strlen starts from 0 so to get number of characters deduct 1
        for ($p = 0; $p < 1; ++$p) {
            $pass = '';
            for ($i = 0; $i < $length; ++$i) {
                $n = rand(0, $symbols_length); // get a random character from the string with all characters
                $pass .= $used_symbols[$n]; // add the character to the password string
            }
            $passwords = $pass;
        }
        return $passwords; // return the generated password
    }
}

if (!function_exists('generateFilename')) {
    function generateFilename()
    {
        return str_replace([' ', ':', '-'], '', \Carbon::now()->toDateTimeString()) . generateRandomString(10, 'lower_case,upper_case,numbers');
    }
}
if (!function_exists('uploadDir')) {
    function uploadDir($folder = '', $filename = false)
    {
        return config('app.uploadDir') . $folder . ($filename ? '/' . $filename : '');
    }
}

if (!function_exists('uploadFile')) {
    function uploadFile($filename = false, $type = 'image', $dir = '', $cdn = true)
    {
        $randomString = generateFilename();
        if ($cdn == true) {
            $s3 = \Storage::disk('s3');
        }
        if (request()->hasFile($filename)) {
            $mediaFile = request()->file($filename);
            $uploadFileName = $randomString . '.' . $mediaFile->getClientOriginalExtension();
            if ($type == 'image') {
                if ($cdn == true) {
                    $imagePath = uploadDir($dir, $uploadFileName);
                    $response = $s3->put($imagePath, file_get_contents($mediaFile), 'public');
                } else {
                    $file_path = uploadDir($dir);
                    $response = $mediaFile->move($file_path, $uploadFileName);
                }
                if ($response) {
                    return $uploadFileName;
                }
            }
            if ($type == 'audio') {
                if ($cdn == true) {
                    $audioPath = uploadDir($dir, $uploadFileName);
                    $response = $s3->put($audioPath, file_get_contents($mediaFile), 'public');
                } else {
                    $file_path = uploadDir($dir);
                    $response = $mediaFile->move($file_path, $uploadFileName);
                }
                if ($response) {
                    return $uploadFileName;
                }
            }
            if ($type == 'video') {
                if ($cdn == true) {
                    $videoPath = uploadDir($dir, $uploadFileName);
                    $response = $s3->put($videoPath, file_get_contents($mediaFile), 'public');
                } else {
                    $videoPath = uploadDir($dir);
                    $response = $mediaFile->move($videoPath, $uploadFileName);
                }
                if ($response) {
                    return $uploadFileName;
                }
            }
        }
        if ($type == 'thumbnail') {
            $videoFilePath = $filename;
            $thumbnail_image = $randomString . '.jpg';
            $imagePath = uploadDir($dir, $thumbnail_image);
            $extC = pathinfo($videoFilePath, PATHINFO_EXTENSION);
            if ($extC == 'mov') {
                exec("ffmpeg -i {$videoFilePath} -c:v libx264 -c:a aac -strict experimental {$imagePath}");
            } else {
                exec("ffmpeg -i {$videoFilePath} -vcodec h264 -acodec aac -strict -2 {$imagePath}");
            }
            exec("ffmpeg  -i {$videoFilePath} -deinterlace -an -ss 2 -f mjpeg -t 1 -r 1 -y -s 400x300 {$imagePath} 2>&1");
            if ($cdn == true) {
                $mediaFile = public_path($imagePath);
                $response = $s3->put($imagePath, file_get_contents($mediaFile), 'public');
            } else {
                $response = true;
            }
            if ($response) {
                if ($cdn == true) {
                    unlink($mediaFile);
                }
                return $thumbnail_image;
            }
        }
        return false;
    }
}
if (!function_exists('cpTrans')) {
    function cpTrans($template = '', $object = [])
    {
        $output = '';
        if (!empty($template)) {
            $output = __("admin.${template}", $object);
        }
        return $output;
    }}

if (!function_exists('cdnLink')) {
    function cdnLink($file_path = false, $local = false)
    {
        // if ($local == false) {
        //     return env('AWS_URL') . '/' . $file_path;
        // }
        return \URL::to($file_path);
    }
}

if (!function_exists('systemLink')) {
    function systemLink($file_path = false)
    {
        return \URL::to(env('urlPrefix') . '/' . $file_path);
    }
}

if (!function_exists('buildFileLink')) {
    function buildFileLink($filename, $folder = '', $local = false)
    {
        return $filename ? cdnLink(uploadDir($folder, $filename), $local) : '';
    }
}

if (!function_exists('buildArrayToTree')) {
    function buildArrayToTree($ori)
    {
        $tree = array();
        if (count($ori)) {
            foreach ($ori as $key => $var) {
                if (isset($tree[$var['attribute_group_id']]['children'])) {
                    $tree[$var['attribute_group_id']]['children'][] = array(
                        'attribute_id' => $var['attribute_id'],
                        'attribute_name' => $var['attribute_name'],
                        'en_attribute_name' => $var['en_attribute_name'],
                        'attribute_value' => $var['attribute_value'],
                    );
                } else {
                    $tree[$var['attribute_group_id']] = array(
                        'attribute_group_id' => $var['attribute_group_id'],
                        'attribute_group_name' => $var['attribute_group_name'],
                        'en_attribute_group_name' => $var['en_attribute_group_name'],
                        'children' => array(array(
                            'attribute_id' => $var['attribute_id'],
                            'attribute_name' => $var['attribute_name'],
                            'en_attribute_name' => $var['en_attribute_name'],
                            'attribute_value' => $var['attribute_value'],
                        )),
                    );

                }
            }
        }
        return array_values($tree);
    }
}
if (!function_exists('hashToken')) {
    function hashToken()
    {
        return md5(uniqid(rand(), true));
    }
}

//Navigation Code Start Here
if (!function_exists('getGroupNavigation')) {
    function getGroupNavigation($all = false)
    {
        $navigations = \App\Models\Navigations::select([
            'id', 'name', 'en_name', 'icon', 'parent_id', 'action_path', 'show_in_menu',
        ])->where([
            'status' => 'Active',
            'show_in_permission' => 'Yes',
        ])->get();
        if ($navigations->isNotEmpty()) {
            $navigations = arrayToTree($navigations->toArray(), null, $all);
        }
        return $navigations;
    }
}
if (!function_exists('getDepartmentPermission')) {
    function getDepartmentPermission($accessDepartmentId)
    {
        return \App\Models\DepartmentPermissions::where([
            'department_id' => $accessDepartmentId,
        ])->pluck('navigation_id')->toArray();
    }
}
if (!function_exists('getAdminPermission')) {
    function getAdminPermission($accessAdminId)
    {
        return \App\Models\AdminPermissions::where([
            'admin_id' => $accessAdminId,
        ])->pluck('navigation_id')->toArray();
    }
}
if (!function_exists('getAdminPermissionIDs')) {
    function getAdminPermissionIDs($accessAdminId, $accessDepartmentId)
    {
        $adminPermissions = getAdminPermission($accessAdminId);
        if (count($adminPermissions)) {
            return $adminPermissions;
        } else {
            return getDepartmentPermission($accessDepartmentId);
        }
    }
}
if (!function_exists('arrayToTree')) {
    function arrayToTree(array $elements, $parentId = 0, $all = false, $parentIdKey = 'parent_id', $id = 'id')
    {
        $output = array();
        foreach ($elements as $element) {
            if ($all) {
                if ($element[$parentIdKey] == $parentId) {
                    $children = arrayToTree($elements, $element[$id], $all, $parentIdKey, $id);
                    if ($children) {
                        $element['children'] = $children;
                    }
                    $output[] = $element;
                }
            } else {
                if ($element['show_in_menu'] == "Yes") {
                    if ($element[$parentIdKey] == $parentId) {
                        $children = arrayToTree($elements, $element[$id], $all, $parentIdKey, $id);
                        if ($children) {
                            $element['children'] = $children;
                        }
                        $output[] = $element;
                    }
                }
            }
        }
        return $output;
    }
}
if (!function_exists('navigationMenuListing')) {
    function navigationMenuListing($guard = 'admin', $saveSession = true, $accessAdminId = null, $accessDepartmentId = null)
    {
        $excludeDepartmentId = config('app.excludeDepartmentId');
        if ($saveSession == true) {
            $guardData = \Auth::guard($guard)->user();
            $accessAdminId = $guardData->id;
            $accessDepartmentId = $guardData->department_id;
        }
        if ($excludeDepartmentId == $accessDepartmentId) {
            $navigations = \App\Models\Navigations::select([
                'id', 'name', 'en_name', 'icon', 'parent_id', 'action_path', 'show_in_menu',
            ])
                ->where(['status' => 'Active'])
                ->orderBy('priority', 'asc')
                ->get();
        } else {
            $allowedNavIds = getAdminPermissionIDs($accessAdminId, $accessDepartmentId);
            $navigations = \App\Models\Navigations::select([
                'id', 'name', 'en_name', 'icon', 'parent_id', 'action_path', 'show_in_menu',
            ])
                ->whereIn('id', $allowedNavIds)
                ->where(['status' => 'Active'])
                ->orderBy('priority', 'asc')
                ->get();
        }
        if ($saveSession == true) {
            if (\Session::exists('navigationPermissions')) {
                \Session::remove('navigationPermissions');
            }
            \Session::put('navigationPermissions', $navigations->toArray());
            \Session::save();
        }

        if ($navigations->isNotEmpty()) {
            $navigations = arrayToTree($navigations->toArray(), null);
        }
        if ($saveSession == true) {
            if (\Session::exists('navigations')) {
                \Session::remove('navigations');
            }
            \Session::put('navigations', $navigations);
            \Session::save();
        } else {
            return $navigations;
        }
    }
}
if (!function_exists('hasAccess')) {
    function hasAccess($actionPath, $exclude = false)
    {
        if (\Auth::guard('admin')->check()) {
            if (!\Session::get('navigations')) {
                navigationMenuListing();
            }
        }

        if ($exclude == true) {return true;}
        if (\Session::exists('navigationPermissions')) {
            $navigationPermissions = \Session::get('navigationPermissions');
            $key = array_search($actionPath, array_column($navigationPermissions, 'action_path'));
            if ($key !== false) {return true;} else {return false;}
        }
        return false;
    }
}
