<form class="application-form" method="post" action="{{ url('/applications') }}">
    @csrf
    <input type="hidden" name="source" value="{{ $source }}">
    <div class="honeypot" aria-hidden="true"><label>Не заполняйте это поле<input name="website" tabindex="-1" autocomplete="off"></label></div>
    @if(session('dzudo_application_sent'))
        <div class="form-success" role="status">Спасибо! Номер принят. Позвоним и расскажем о занятиях.</div>
    @endif
    <label class="phone-label" for="phone-{{ $source }}">Номер телефона</label>
    <div class="phone-row"><input id="phone-{{ $source }}" name="phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="+7 900 000-00-00" value="{{ old('phone') }}" required>@error('phone')<span class="field-error">{{ $message }}</span>@enderror<button class="button button-red" type="submit">{{ $button }} <span>↗</span></button></div>
    <label class="consent-label"><input type="checkbox" name="consent" value="1" required @checked(old('consent'))><span>Согласен(на) на обработку номера для ответа по заявке. <a href="#privacy-note">Подробнее</a></span></label>
    @error('consent')<span class="field-error">{{ $message }}</span>@enderror
</form>
