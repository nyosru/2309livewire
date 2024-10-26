<div class="player-container">

    <style>
        .animated-background {
            background-size: 400% 400%;
            animation: gradient 60s ease infinite;
            xpadding: 20px;
            xborder-radius: 12px;
            xfont-size: 24px;
        }

        @keyframes gradient {
            0% {background-position: 0% 50%}
            25% {background-position: 100% 50%}
            75% {background-position: 0% 50%}
            100% {background-position: 100% 50%}
        }
    </style>

    {{--        <div class="bg-gradient-to-br from-pink-500 to-purple-600 md:bg-gradient-to-r py-10 shadow-2xl">--}}

    <div class="animated-background bg-gradient-to-br from-blue-300 via-purple-500 to-green-200 xrounded-2xl xxp-4 text-2xl">
{{--    <div class="bg-gradient-to-br from-blue-300 to-green-200 xrounded-2xl xp-4 xtext-2xl">--}}
        <div class="flex flex-row">

            {{-- @if( !$show_res_ok )--}}
            {{-- <p>Заполните форму, и мы позвоним, ответим на вопросы и начнём приватизацию.</p>--}}
            {{-- <br/>--}}

            <div class="lg:basis-1/2 w-full text-center text-xl py-[5rem] lg:pt-[50px]">

                <h2 class="font-bold text-3xl text-white" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);">Наша песня!! Премьера!!</h2>

                <br/>
                <audio class="mx-auto inline-block" id="audioPlayer" controls src="/zem/mp3/PrivatizaciyaGarageSong.mp3"></audio>
                <br/>
                <br/>
                <a href="/zem/mp3/PrivatizaciyaGarageSong.mp3"
                   class="text-blue-800 cursor-pointer underline hover:bg-yellow-400 px-2 py-1"
                   target="_blank">скачать песню mp3</a> / <A
                    class="text-blue-800 cursor-pointer underline hover:bg-yellow-400 px-2 py-1"
                    href="https://vk.com/wall-224600570_4" target="_blank">слушать на vk.com</a>

                @if(1==2)
                    <style>
                        .player-container {
                            width: 400px;
                            text-align: center;
                            border-radius: 10px;
                            padding: 20px;
                            box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
                            background-color: white;
                        }

                        button {
                            cursor: pointer;
                            padding: 10px 15px;
                            border: none;
                            border-radius: 5px;
                            background-color: #007bff;
                            color: white;
                            font-size: 16px;
                            transition: background-color 0.3s ease;
                        }

                        button:hover {
                            background-color: #0056b3;
                        }

                        input[type=range] {
                            width: 200px;
                            margin-top: 10px;
                        }

                        .time-progress {
                            font-size: 14px;
                            margin-top: 10px;
                        }
                    </style>
                @endif
                @if(1==2)
                    <button onclick="playPause()">Play</button>
                    <input type="range" min="0" max="100" value="0" step="1" onchange="setVolume(this.value)"
                           id="volumeSlider"/>
                    <div class="time-progress">00:00 / 00:00</div>

                    <script>
                        const audio = document.getElementById('audioPlayer');
                        let isPlaying = false;

                        function playPause() {
                            if (!isPlaying) {
                                audio.play();
                                document.querySelector('button').innerText = 'Pause';
                                isPlaying = true;
                            } else {
                                audio.pause();
                                document.querySelector('button').innerText = 'Play';
                                isPlaying = false;
                            }
                        }

                        function setVolume(volume) {
                            audio.volume = volume / 100;
                        }

                        // Обновление текущего времени воспроизведения
                        audio.addEventListener('loadedmetadata', () => {
                            const duration = formatTime(audio.duration);
                            document.querySelector('.time-progress').innerHTML = `00:00 / ${duration}`;
                        });

                        audio.addEventListener('timeupdate', () => {
                            const currentTime = formatTime(audio.currentTime);
                            const duration = formatTime(audio.duration);
                            document.querySelector('.time-progress').innerHTML = `${currentTime} / ${duration}`;
                        });

                        // Форматирование времени в формате MM:SS
                        function formatTime(time) {
                            const minutes = Math.floor(time / 60);
                            let seconds = Math.floor(time % 60);
                            seconds = seconds < 10 ? '0' + seconds : seconds;
                            return `${minutes}:${seconds}`;
                        }
                    </script>
                @endif

            </div>

            <div class="lg:basis-1/2 text-center min-h-[400px] hidden lg:flex" style="background-image: url('/zem/premiera.jpg'); background-position: center center;">
{{--                <img src="" />--}}
            </div>
        </div>
    </div>


</div>
