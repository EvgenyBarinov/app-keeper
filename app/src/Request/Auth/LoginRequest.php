<?php

/**
 * {project-name}
 *
 * @author {author-name}
 */

declare(strict_types=1);

namespace App\Request\Auth;

use Spiral\Filters\Filter;

class LoginRequest extends Filter
{
    private const DEFAULT_DURATION  = 'PT24H';
    private const REMEMBER_DURATION = 'PT30D';

    protected const SCHEMA = [
        'username' => 'data:username',
        'password' => 'data:password',
        'code'     => 'data:code',
        'remember' => 'data:remember'
    ];

    protected const VALIDATES = [
        'username' => ['notEmpty', 'string'],
        'password' => ['notEmpty', 'string'],
        'remember' => ['boolean'],
        'code'     => ['string']
    ];

    protected const SETTERS = [
        'username' => 'strval',
        'password' => 'strval',
        'code'     => 'strval',
        'remember' => 'boolval'
    ];

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return (string) $this->getField('username');
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return (string) $this->getField('password');
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        if ($this->getField('code') === '') {
            return null;
        }

        return $this->getField('code');
    }

    /**
     * @return \DateTimeInterface
     */
    public function getSessionExpiration(): \DateTimeInterface
    {
        $now = new \DateTime();

        if ((bool) $this->getField('rememberMe')) {
            return $now->add(new \DateInterval(self::REMEMBER_DURATION));
        }

        return $now->add(new \DateInterval(self::DEFAULT_DURATION));
    }
}
