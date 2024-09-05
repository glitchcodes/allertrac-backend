<?php

namespace App\Enums;

enum HttpCodes: string
{
    // 200 OK
    case OK = 'OK';
    // 201 Created
    case CREATED = 'CREATED';
    // 202 Accepted
    case ACCEPTED = 'ACCEPTED';

    // 204 No Content
    case RESOURCE_DELETED = 'RESOURCE_DELETED';
    case NO_CONTENT = 'NO_CONTENT';

    // 400 Bad Request
    case INVALID_REQUEST = 'INVALID_REQUEST';
    case MISSING_PARAMETERS = 'MISSING_PARAMETERS';

    // 401 Unauthorized
    case UNAUTHORIZED = 'UNAUTHORIZED';
    case INVALID_CREDENTIALS = 'INVALID_CREDENTIALS';
    case TOKEN_EXPIRED = 'TOKEN_EXPIRED';

    // 403 Forbidden
    case FORBIDDEN = 'FORBIDDEN';
    case ACCESS_DENIED = 'ACCESS_DENIED';

    // 404 Not Found
    case NOT_FOUND = 'NOT_FOUND';
    case RESOURCE_NOT_FOUND = 'RESOURCE_NOT_FOUND';

    // 405 Method Not Allowed
    case METHOD_NOT_ALLOWED = 'METHOD_NOT_ALLOWED';
    case INVALID_METHOD = 'INVALID_METHOD';

    // 409 Conflict
    case CONFLICT = 'CONFLICT';
    case RESOURCE_CONFLICT = 'RESOURCE_CONFLICT';

    // 422 Unprocessable Entity
    case INPUT_INVALID = 'INPUT_INVALID';
    case UNPROCESSABLE_ENTITY = 'UNPROCESSABLE_ENTITY';

    // 500 Internal Server Error
    case INTERNAL_SERVER_ERROR = 'INTERNAL_SERVER_ERROR';
    case SERVER_ERROR = 'SERVER_ERROR';

    // 503 Service Unavailable
    case SERVICE_UNAVAILABLE = 'SERVICE_UNAVAILABLE';
    case MAINTENANCE_MODE = 'MAINTENANCE_MODE';

    /**
     * Get the HTTP status code associated with the error code.
     */
    public function getHttpStatusCode(): int
    {
        return match($this) {
            self::OK => 200,
            self::CREATED => 201,
            self::ACCEPTED => 202,
            self::RESOURCE_DELETED, self::NO_CONTENT => 204,
            self::INVALID_REQUEST, self::MISSING_PARAMETERS => 400,
            self::UNAUTHORIZED, self::INVALID_CREDENTIALS, self::TOKEN_EXPIRED => 401,
            self::FORBIDDEN, self::ACCESS_DENIED => 403,
            self::NOT_FOUND, self::RESOURCE_NOT_FOUND => 404,
            self::METHOD_NOT_ALLOWED, self::INVALID_METHOD => 405,
            self::CONFLICT, self::RESOURCE_CONFLICT => 409,
            self::INPUT_INVALID, self::UNPROCESSABLE_ENTITY => 422,
            self::INTERNAL_SERVER_ERROR, self::SERVER_ERROR => 500,
            self::SERVICE_UNAVAILABLE, self::MAINTENANCE_MODE => 503,
        };
    }
}
