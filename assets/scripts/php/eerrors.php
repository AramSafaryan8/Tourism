<?php
declare(strict_types = 1);

namespace Scripts;

class EErrors
{
    private static $arr = [
        'incorrectdata' => [
            'title' => 'Incorrect data!',
            'msg' => 'One of the required fields contains incorrect data. Check the correctness of the required fields.',
            'headers' => [
                'statusCode' => 422,
                'reason' => 'Incorrect data'
            ]
        ],
        'invalidrequest' => [
            'title' => 'Invalid data!',
            'msg' => 'The constructed request is malformed.',
            'headers' => [
                'statusCode' => 400,
                'reason' => 'Bad Request'
            ]
        ],
        'duplicate' => [
            'title' => 'Cannot create account!',
            'msg' => 'A record with the provided data already exists.',
            'headers' => [
                'statusCode' => 422,
                'reason' => 'Duplicate data'
            ]
        ],
        'notfound' => [
            'title' => 'Not Found',
            'msg' => 'The page you are looking for is either deleted or doesn\'t exist at all.',
            'headers' => [
                'statusCode' => 404,
                'reason' => 'Not Found'
            ]
        ],
        'authrequired' => [
            'title' => 'Authentication required!',
            'msg' => 'You will need to sign in to continue.',
            'headers' => [
                'statusCode' => 401,
                'reason' => 'Unauthorized'
            ]
        ],
        'dbconn' => [
            'title' => 'Troubles with server',
            'msg' => 'Currently we\'re having issues with the server connection. Please try later.',
            'headers' => [
                'statusCode' => 500,
                'reason' => 'Server connection'
            ]
        ]
    ];

    public static function get(string $name) : ?array {
        return (isset(self::$arr[$name])) ? self::$arr[$name] : NULL;
    }
}