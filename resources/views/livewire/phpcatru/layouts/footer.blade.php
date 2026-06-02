<footer class="w-full py-3 text-center text-gray-500 text-xs font-medium"
        style="
            background: linear-gradient(90deg, #e5e7eb, #d1d5db, #e5e7eb, #d1d5db);
            background-size: 300% 100%;
            animation: moveGradient 10s ease-in-out infinite;
        ">
    Все права защищены &copy; {{ date('Y') }} | Создание сайта: <a href="https://php-cat.com" target="_blank"
        class="underline hover:text-gray-700 transition">php-cat.com</a>
    <br/>
    Сервис CRM / летопись для вдения бищнес и личных дел : <a href="https://процессмастер.рф" target="_blank"
        class="underline hover:text-gray-700 transition">ПроцессМастер.рф</a>

    <style>
        @keyframes moveGradient {
            0% { background-position: 0% 0; }
            50% { background-position: 100% 0; }
            100% { background-position: 0% 0; }
        }
    </style>
</footer>
