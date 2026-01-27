protected $routeMiddleware = [
// ...
'admin' => \App\Http\Middleware\AdminMiddleware::class,
'organizer' => \App\Http\Middleware\OrganizerMiddleware::class,
];
