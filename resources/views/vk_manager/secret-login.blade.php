<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Вход без VK — управление аккаунтом</title>
    <style>
        *{box-sizing:border-box}body{margin:0;background:#f3f6fa;color:#17212b;font:16px/1.5 Arial,sans-serif}.wrap{max-width:560px;margin:10vh auto;padding:24px}.card{background:#fff;border:1px solid #dce3eb;border-radius:18px;padding:32px;box-shadow:0 12px 36px #18314a12}h1{font-size:30px;line-height:1.2;margin:0 0 12px}.muted{color:#607080}.field{display:grid;gap:6px;margin-top:18px}.field input{width:100%;padding:12px;border:1px solid #ccd6e0;border-radius:9px;font:inherit}.button{display:inline-block;margin-top:22px;background:#0077ff;color:#fff;padding:13px 20px;border:0;border-radius:10px;text-decoration:none;font-weight:700;font-size:16px;cursor:pointer}.error{color:#b42318;margin-top:16px}.field-error{color:#b42318;font-size:14px}.back{margin-top:18px}
    </style>
</head>
<body>
<main class="wrap">
    <section class="card">
        <h1>Вход без VK</h1>
        <p class="muted">Укажите VK ID уже зарегистрированного на сайте аккаунта и секрет для входа.</p>
        <form id="secret-login-form" autocomplete="off">
            <label class="field">
                <span>VK ID пользователя</span>
                <input id="secret-login-vk-id" name="vk_id" inputmode="numeric" pattern="[0-9]+" maxlength="20" value="{{ old('vk_id') }}" required>
                @error('vk_id')<span class="field-error">{{ $message }}</span>@enderror
            </label>
            <label class="field">
                <span>Секрет</span>
                <input id="secret-login-secret" name="secret" type="password" autocomplete="new-password" required>
                @error('secret')<span class="field-error">{{ $message }}</span>@enderror
            </label>
            <button class="button" type="submit">Войти</button>
        </form>
        <p class="back"><a href="/login">Назад ко входу через VK</a></p>
    </section>
</main>
<script>
document.getElementById('secret-login-form').addEventListener('submit', event => {
    event.preventDefault();
    const vkId = document.getElementById('secret-login-vk-id').value.trim();
    const secret = document.getElementById('secret-login-secret').value;
    if (!/^[0-9]{1,20}$/.test(vkId) || !secret) return;
    window.location.assign(`/a/${encodeURIComponent(secret)}/${encodeURIComponent(vkId)}`);
});
</script>
</body>
</html>
