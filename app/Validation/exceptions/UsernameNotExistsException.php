<?php

namespace Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class UsernameNotExistsException extends ValidationException {
    public static $defaultTemplates = array(
        self::MODE_DEFAULT => [
            'Le nom d\'utilisateur existe déja'
        ],
        self::MODE_NEGATIVE => [
            'Le nom d\'utilisateur existe déja'
        ]
    );
}