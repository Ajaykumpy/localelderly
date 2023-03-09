<?php

return [
    'http' => [
        'server_key'       => config('constants.android_push_key', 'oldAAAAHiN8l3M:APA91bFjpnzBYdD1y34ZjAdHJQpfiRsLjifnslVHSPOpkHFnNEQq38vkUSrXWPM67WE_LKPrleNcXeyJ306cy6MQIxS9uTc4yG4CDRwJ---OekGwOXWuZxCWG35OvQNJhnbgKtGiwIu6'),
        'sender_id'        => config('constants.android_sender_key', '129444386675'),
        'server_send_url'  => 'https://fcm.googleapis.com/fcm/send',
        'timeout'          => 30.0, // in second
    ],
];
