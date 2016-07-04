Witaj <?php echo $user_name; ?>!<br/><br/>

Dziękujemy za stworzenie konta w naszym serwisie. Twoje konto nie jest jeszcze aktywne.<br/>
Aby je aktywować kliknij na link poniżej.<br/><br/>

<?php echo Route::url('bauth/frontend/auth/activate', array('hash' => $user_hash), 'http') ?><br/><br/>

---<br/>
Ten email został wygenerowany automatycznie. Nie odpowiadaj na niego.