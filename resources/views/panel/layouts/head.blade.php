<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->user()->id }}">
    <title>Kanban System | Dashboard</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/css/panel/index.css',
        'resources/js/panel/column.js',
        'resources/js/panel/home.js',
        'resources/js/panel/forms/create-column.js',
        'resources/js/panel/forms/edit-column.js',
        'resources/js/panel/forms/delete-column.js',
        'resources/js/panel/forms/create-task.js',
        'resources/js/panel/forms/delete-task.js'
    ])
</head>
