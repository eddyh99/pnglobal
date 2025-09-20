<?php

namespace Config;

use App\Filters\LoginCourseFilter;
use App\Filters\MentorCourseFilter;
use App\Filters\LoginGodmodeFilter;
use App\Filters\LoginLuxbrokerFilter;
use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array<string, class-string|list<class-string>>
     *
     * [filter_name => classname]
     * or [filter_name => [classname1, classname2, ...]]
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,
        'isLoggedInCourse'   => LoginCourseFilter::class,
        'isMentor'   => MentorCourseFilter::class,
        'isGodmode'     => LoginGodmodeFilter::class,
        'isLoggedInLux' => LoginLuxbrokerFilter::class
    ];

    /**
     * List of special required filters.
     *
     * The filters listed here are special. They are applied before and after
     * other kinds of filters, and always applied even if a route does not exist.
     *
     * Filters set by default provide framework functionality. If removed,
     * those functions will no longer work.
     *
     * @see https://codeigniter.com/user_guide/incoming/filters.html#provided-filters
     *
     * @var array{before: list<string>, after: list<string>}
     */
    public array $required = [
        'before' => [
            'forcehttps', // Force Global Secure Requests
            'pagecache',  // Web Page Caching
        ],
        'after' => [
            'pagecache',   // Web Page Caching
            'performance', // Performance Metrics
            'toolbar',     // Debug Toolbar
        ],
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array<string, array<string, array<string, string>>>|array<string, list<string>>
     */
    public array $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
        ],
        'after' => [
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'POST' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don't expect could bypass the filter.
     *
     * @var array<string, list<string>>
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array<string, array<string, list<string>>>
     */
    public array $filters = [
        'isGodmode' => [
            'before' => [
                'godmode/dashboard',
                'godmode/dashboard/*',
                'godmode/payment/*',
                'godmode/hedge/*',
                'godmode/referral/*',
                'godmode/message',
                'godmode/freemember',
                'godmode/giveaway',
                'godmode/signal',
                'godmode/admin',
                'godmode/onetoone',
                'godmode/onetoone/*',
                'godmode/mediation',
                'godmode/history-hedgefund',
                'godmode/bank_account',
                'godmode/otc',
                'godmode/interest',
            ],
        ],
        'isLoggedInLux' => [
            'before' => [
                'member/dashboard',
                'member/membership',
                'member/referral',
                'member/withdraw'
            ],
        ],
        'isLoggedInCourse' => [
            'before' => [
                'course/member/*',
            ],
        ],
        'isMentor' => [
            'before' => [
                'course/mentor/*',
            ],
        ]
    ];    
}
