<?php 

return [
	'email' 		=> env('SMS_ME_EMAIL', 'admin@admin.com'),
	'password'		=> env('SMS_ME_PASSWORD', 'admin@admin.com'),
	'device'		=> env('SMS_ME_DEVICE', '12345'),
	'api'			=> env('SMS_ME_API', 'http://smsgateway.me/api/v3/messages/send'),
	'token'			=> env('SMS_ME_TOKEN', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTUzMTA1NzE2MCwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjQ4MjM3LCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.VtC64jrTffrIdW5wx9eogrnyk1LuDVWM_2TRyF1Y7RM')
];