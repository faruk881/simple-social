<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple Social API</title>

    <meta name="description" content="Simple Social is a Laravel Sanctum based REST API project with user roles, posts, comments, likes, reports, and admin moderation.">
    <meta name="author" content="MD Omar Faruk">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        :root {
            --bg: #ffffff;
            --text: #24292f;
            --muted: #57606a;
            --border: #d0d7de;
            --code-bg: #f6f8fa;
            --accent: #0969da;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI",
                         Helvetica, Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
        }

        main {
            max-width: 920px;
            margin: auto;
            padding: 40px 20px;
        }

        h1, h2, h3 {
            line-height: 1.25;
        }

        h1 {
            font-size: 2.5rem;
            border-bottom: 1px solid var(--border);
            padding-bottom: 10px;
        }

        h2 {
            margin-top: 48px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 6px;
        }

        p {
            color: var(--text);
        }

        ul, ol {
            margin-left: 22px;
        }

        li {
            margin: 6px 0;
        }

        code {
            background: var(--code-bg);
            padding: 2px 6px;
            border-radius: 6px;
            font-size: 0.95em;
        }

        pre {
            background: var(--code-bg);
            padding: 16px;
            border-radius: 8px;
            overflow-x: auto;
            border: 1px solid var(--border);
        }

        a {
            color: var(--accent);
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        footer {
            margin-top: 60px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            color: var(--muted);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<main>

    <h1>Simple Social</h1>

    <p>
        <strong>Simple Social</strong> is a RESTful API built with
        <strong>Laravel</strong> and secured using
        <strong>Laravel Sanctum</strong>.
        It provides a backend foundation for a basic social media platform.
    </p>

    <p>
        The project demonstrates real-world API concepts such as authentication,
        role-based authorization, post moderation, and user interactions.
    </p>

    <h2>🚀 Features</h2>

    <h3>🔐 Authentication & Authorization</h3>
    <ul>
        <li>Token-based authentication with Laravel Sanctum</li>
        <li>User registration and login</li>
        <li>Role-based access control (Admin / Normal User)</li>
    </ul>

    <h3>👤 Users</h3>
    <ul>
        <li>User creation and management</li>
        <li>Admin and Normal user roles</li>
    </ul>

    <h3>📝 Posts</h3>
    <ul>
        <li>Users can create posts</li>
        <li>Admin approval required before public visibility</li>
    </ul>

    <h3>💬 Comments & Replies</h3>
    <ul>
        <li>Comment on posts</li>
        <li>Reply to comments (nested replies)</li>
    </ul>

    <h3>❤️ Likes</h3>
    <ul>
        <li>Like posts and comments</li>
        <li>Like / unlike toggle support</li>
    </ul>

    <h3>🚩 Reports</h3>
    <ul>
        <li>Report posts or comments</li>
        <li>Admin moderation of reported content</li>
    </ul>

    <h2>🛠️ Tech Stack</h2>
    <ul>
        <li>Laravel</li>
        <li>Laravel Sanctum</li>
        <li>MySQL</li>
        <li>REST API</li>
    </ul>

    <h2>⚙️ Installation</h2>

    <pre><code>git clone &lt;repository-url&gt;
cd simple-social
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve</code></pre>

    <h2>🔑 Authentication Flow</h2>
    <ol>
        <li>User logs in or registers</li>
        <li>Sanctum issues an access token</li>
        <li>Token is sent via Authorization header</li>
        <li>Protected routes validate the token</li>
    </ol>

    <h2>🛡️ Authorization Rules</h2>
    <ul>
        <li><strong>Normal Users:</strong> post, comment, reply, like, report</li>
        <li><strong>Admin:</strong> approve posts, review reports, moderate content</li>
    </ul>

    <h2>📌 API Highlights</h2>
    <ul>
        <li><code>POST /api/register</code></li>
        <li><code>POST /api/login</code></li>
        <li><code>POST /api/posts</code></li>
        <li><code>PUT /api/posts/{id}/approve</code></li>
        <li><code>POST /api/comments</code></li>
        <li><code>POST /api/likes</code></li>
        <li><code>POST /api/reports</code></li>
    </ul>

    <h2>🎯 Purpose</h2>
    <ul>
        <li>Practice Laravel Sanctum</li>
        <li>Learn API authentication & authorization</li>
        <li>Understand social media backend logic</li>
    </ul>

    <footer>
        <p>
            © Simple Social — Built by <strong>MD Omar Faruk</strong><br>
            Open-source • Educational use
        </p>
    </footer>

</main>

</body>
</html>
