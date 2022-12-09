@php
    $cookie = App\Models\CookieConsent::first();

   
@endphp

<div class="js-cookie-consent cookie-consent cookie-modal">

    <div class="cookies-card__icon">
        <i class="fas fa-cookie-bite"></i>
      </div>

    <span class="cookie-consent__message">
        {{__($cookie->cookie_text)}}
    </span>

    <button class="js-cookie-consent-agree cookie-consent__agree btn">
        {{ __($cookie->button_text) }}
    </button>
   

</div>




