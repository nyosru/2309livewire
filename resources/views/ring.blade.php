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
            font-size: 1.2em;
            padding: 10px 20px;
            cursor: pointer;
            margin: 5px;
        }
        .adjust-btn {
            font-size: 1.2em;
            width: 30px;
            height: 30px;
            margin: 0 10px;
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
    </style>
</head>
<body>
<h1>Таймер со звуком</h1>
<div class="time-container">
    <label for="hours">Часы:</label>
    <button class="adjust-btn" onclick="adjustTime('hours', -1)">-</button>
    <input type="number" id="hours" min="0" value="0">
    <button class="adjust-btn" onclick="adjustTime('hours', 1)">+</button>
</div>
<div class="time-container">
    <label for="minutes">Минуты:</label>
    <button class="adjust-btn" onclick="adjustTime('minutes', -1)">-</button>
    <input type="number" id="minutes" min="0" value="0">
    <button class="adjust-btn" onclick="adjustTime('minutes', 1)">+</button>
</div>
<div class="time-container">
    <label for="seconds">Секунды:</label>
    <button class="adjust-btn" onclick="adjustTime('seconds', -1)">-</button>
    <input type="number" id="seconds" min="0" max="59" value="0">
    <button class="adjust-btn" onclick="adjustTime('seconds', 1)">+</button>
</div>
<div class="checkbox-container">
    <label for="half-second">Пол секунды</label>
    <input type="checkbox" id="half-second">
</div>
<div class="sound-select-container">
    <label for="sound-select">Выберите звук:</label>
    <select id="sound-select">
        <option value="/timer_rings/ring.mp3">ring.mp3</option>
        <option value="/timer_rings/ring2.mp3">ring2.mp3</option>
        <option value="/timer_rings/ring3.mp3">ring3.mp3</option>
        <option value="/timer_rings/schelchok-shumnyii.mp3">щелчок шумный</option>
        <option value="/timer_rings/malyiy-baraban-odinochnyiy-schelchok.mp3">Малый барабан одиночный щелчок</option>
    </select>
</div>
<br>
<button onclick="startTimer()">Запустить таймер</button>
<button onclick="stopTimer()">Остановить</button>
<div id="countdown"></div>
<div id="seconds-left"></div>
<div class="checkbox-container">
    <label for="one-time">1 раз</label>
    <input type="checkbox" id="one-time">
</div>
<audio id="alarmSound" preload="auto"></audio>

<script>
    let timerInterval;
    let timeLeft;
    let initialTime;
    let soundFile = '/timer_rings/ring.mp3'; // Default sound file

    document.getElementById('sound-select').addEventListener('change', function() {
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
</body>
</html>
