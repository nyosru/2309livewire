<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Таймер со звуком</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
            background: linear-gradient(90deg, #ff9a9e, #fad0c4, #fbc2eb, #a6c0fe);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        @keyframes gradient {
            0% { background-position: 0% 0%; }
            50% { background-position: 100% 100%; }
            100% { background-position: 0% 0%; }
        }
        .time-container {
            display: inline-flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .time-container label {
            margin-right: 10px;
        }
        input {
            font-size: 1.2em;
            padding: 5px;
            width: 50px;
            text-align: center;
        }
        button {
            font-size: 1.5em;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f5f5f5;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #e0e0e0;
        }
        .control-button {
            width: auto;
            display: inline;
            font-size: 1.2em;
            padding: 10px 20px;
            margin: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f5f5f5;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .control-button:hover {
            background-color: #e0e0e0;
        }
        #countdown {
            font-size: 2em;
            margin-top: 20px;
        }
        #seconds-left {
            font-size: 1.5em;
            margin-top: 20px;
            color: red;
        }
        .checkbox-container {
            display: inline-flex;
            align-items: center;
            margin-left: 20px;
        }
        .sound-select-container {
            margin-top: 20px;
        }
        .content_foot {
            position: fixed;
            bottom: 20px;
            right: 30px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px 10px;
            padding: 10px 15px;
            font-size: 1rem;
        }
        .content_foot a {
            color: #1e90ff;
            text-decoration: underline;
        }
    </style>
</head>
<body>
<h1>Таймер со звуком</h1>
<div class="time-container">
    <label for="hours">Часы:</label>
    <button onclick="adjustTime('hours', -1)">-</button>
    <input type="number" id="hours" min="0" value="0">
    <button onclick="adjustTime('hours', 1)">+</button>
</div>
<div class="time-container">
    <label for="minutes">Минуты:</label>
    <button onclick="adjustTime('minutes', -1)">-</button>
    <input type="number" id="minutes" min="0" value="0">
    <button onclick="adjustTime('minutes', 1)">+</button>
</div>
<div class="time-container">
    <label for="seconds">Секунды:</label>
    <button onclick="adjustTime('seconds', -1)">-</button>
    <input type="number" id="seconds" min="0" max="59" value="0">
    <button onclick="adjustTime('seconds', 1)">+</button>
</div>
<div class="checkbox-container">
    <label for="half-second">Пол секунды</label>
    <input type="checkbox" id="half-second">
</div>
<div class="sound-select-container">
    <label for="sound-select">Выберите звук:</label>
    <select id="sound-select">
        <!-- Options will be populated by JavaScript -->
    </select>
</div>
<br>
<button class="control-button" onclick="startTimer()">Запустить таймер</button>
<button class="control-button" onclick="stopTimer()">Остановить</button>
<div id="countdown"></div>
<div id="seconds-left"></div>
<div class="checkbox-container">
    <label for="one-time">1 раз</label>
    <input type="checkbox" id="one-time">
</div>
<audio id="alarmSound" preload="auto"></audio>

<script>
    const soundFiles = [
        { value: '/timer_rings/ring.mp3', text: 'ring' },
        { value: '/timer_rings/ring2.mp3', text: 'ring2' },
        { value: '/timer_rings/ring3.mp3', text: 'ring3' },
        { value: '/timer_rings/schelchok-shumnyii.mp3', text: 'щелчок шумный' },
        { value: '/timer_rings/malyiy-baraban-odinochnyiy-schelchok.mp3', text: 'Малый барабан одиночный щелчок' },
        { value: '/timer_rings/auto_bipbip_gluhoy-zvuk-gudka-avtomobilya.mp3', text: 'Авто - бип бип' },
        { value: '/timer_rings/bitboxs_pchi.mp3', text: 'БитБокс Птчи' },
        { value: '/timer_rings/myu.mp3', text: 'Мяу' }
    ];

    const soundSelect = document.getElementById('sound-select');

    soundFiles.forEach(sound => {
        const option = document.createElement('option');
        option.value = sound.value;
        option.textContent = sound.text;
        soundSelect.appendChild(option);
    });

    let timerInterval;
    let timeLeft;
    let initialTime;
    let soundFile = soundFiles[0].value; // Default sound file

    soundSelect.addEventListener('change', function() {
        soundFile = this.value;
    });

    function adjustTime(elementId, delta) {
        const input = document.getElementById(elementId);
        let value = parseInt(input.value, 10) + delta;

        if (elementId === 'seconds') {
            if (value < 0) value = 59;
            if (value > 59) value = 0;
        } else {
            if (value < 0) value = 0;
        }

        input.value = value;
    }

    function startTimer() {
        const hours = parseInt(document.getElementById('hours').value, 10);
        const minutes = parseInt(document.getElementById('minutes').value, 10);
        const seconds = parseInt(document.getElementById('seconds').value, 10);
        initialTime = (hours * 3600) + (minutes * 60) + seconds;

        if (document.getElementById('half-second').checked) {
            initialTime += 0.5;
        }

        timeLeft = initialTime;

        if (timerInterval) {
            clearInterval(timerInterval);
        }

        updateCountdown();
        timerInterval = setInterval(() => {
            timeLeft -= 1;
            updateCountdown();

            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                document.getElementById('alarmSound').src = soundFile;
                document.getElementById('alarmSound').play();
                if (!document.getElementById('one-time').checked) {
                    startTimer();
                }
            }
        }, 1000);
    }

    function stopTimer() {
        if (timerInterval) {
            clearInterval(timerInterval);
        }
        document.getElementById('countdown').textContent = "";
        document.getElementById('seconds-left').textContent = "";
    }

    function updateCountdown() {
        const totalSeconds = Math.floor(timeLeft);
        const minutes = Math.floor((totalSeconds % 3600) / 60);
        const hours = Math.floor(totalSeconds / 3600);
        const seconds = totalSeconds % 60;
        document.getElementById('countdown').textContent = `${hours}ч ${minutes}м ${seconds}с`;
        document.getElementById('seconds-left').textContent = `Осталось: ${timeLeft.toFixed(1)} секунд`;
    }
</script>

<div class="content_foot">
    <a href="https://php-cat.com" target="_blank">php-cat.com</a><br/>
    и телеграм <a href="https://t.me/phpcatcom" target="_blank">@phpcatcom</a>
</div>
</body>
</html>
