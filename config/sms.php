<?php 

return [
	'email' 		=> env('SMS_ME_EMAIL', 'admin@admin.com'),
	'password'		=> env('SMS_ME_PASSWORD', 'admin@admin.com'),
	'device'		=> env('SMS_ME_DEVICE', '12345'),
	'api'			=> env('SMS_ME_API', 'http://smsgateway.me/api/v3/messages/send'),
];