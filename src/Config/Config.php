<?php
define('DB_HOST', getenv('DB_HOST') ?: 'mysql');      // ← ¿TIENES MYSQL_HOST en .env? NO
define('DB_NAME', getenv('DB_NAME'));             // ← "Master_Task" ✓
define('DB_USER', getenv('DB_USER') ?: 'root');       // ← ¿TIENES MYSQL_USER? NO, usa 'root'
define('DB_PASS', getenv('DB_PASS'));             // ← "pass" ✓
define('JWT_KEY', getenv('JWT_KEY'));        