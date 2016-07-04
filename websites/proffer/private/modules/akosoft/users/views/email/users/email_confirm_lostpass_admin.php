Witaj <?php echo $user_name ?>!<br/><br/>

Jeśli chcesz ustawić nowe hasło kliknij w link poniżej.<br/>
Jeśli nie chcesz zmieniać hasła zignoruj tego maila.<br/>
Nie przesyłaj nikomu tego linka gdyż jest on stworzony tylko do Twojego konta.<br/><br/>

<?php echo URL::site('/admin/auth/new_password/' . $user_hash, 'http') ?><br/><br/>

---<br/>
Żądanie wysłania tego maila zostało wysłane z komputera:<br/>
<?php echo $ip ?>, <?php echo $host ?>,<br/>
<?php echo $user_agent ?><br/><br/>

Ten email został wygenerowany automatycznie. Nie odpowiadaj na niego.