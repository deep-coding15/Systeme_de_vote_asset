<?php
namespace Core;

/**
 * Enumération des codes de réponse HTTP
 */
enum CODE_RESPONSE: int
{
    case OK = 200;
    case CREATED = 201;
    case ACCEPTED = 202;
    case NO_CONTENT = 204;
    
    case BAD_REQUEST = 400;
    case UNAUTHORIZED = 401;
    case FORBIDDEN = 403;
    case NOT_FOUND = 404;
    case METHOD_NOT_ALLOWED = 405;
    case CONFLICT = 409;
    
    case SERVER_ERROR = 500;
    case NOT_IMPLEMENTED = 501;
    case SERVICE_UNAVAILABLE = 503;
    
    /**
     * Vérifie si le code est un succès (200-299)
     */
    public function isSuccess(): bool
    {
        return $this->value >= 200 && $this->value < 300;
    }
    
    /**
     * Vérifie si le code est une erreur client (400-499)
     */
    public function isClientError(): bool
    {
        return $this->value >= 400 && $this->value < 500;
    }
    
    /**
     * Vérifie si le code est une erreur serveur (500-599)
     */
    public function isServerError(): bool
    {
        return $this->value >= 500 && $this->value < 600;
    }
    
    /**
     * Retourne le message HTTP standard
     */
    public function getMessage(): string
    {
        return match($this) {
            self::OK => 'OK',
            self::CREATED => 'Created',
            self::BAD_REQUEST => 'Bad Request',
            self::UNAUTHORIZED => 'Unauthorized',
            self::FORBIDDEN => 'Forbidden',
            self::NOT_FOUND => 'Not Found',
            self::SERVER_ERROR => 'Internal Server Error',
            default => 'Unknown Status'
        };
    }
}

//CODE_RESPONSE::from(200)