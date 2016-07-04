<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

return array(
	'user' => 'Użytkownik',
	'users.title' => 'Użytkownicy',
	
	'users.generate_pass.btn' => 'generuj',
	
	'users.auth.errors.not_exists'	=> 'Użytkownik nie istnieje!',
	'users.auth.errors.bad_pass'	=> 'Hasło jest błędne!',
	'users.auth.errors.not_active'	=> 'Użytkownik jest nieaktywny!',
	'users.auth.errors.banned'		=> 'Użytkownik jest zbanowany!',
	'users.auth.errors.deleted'		=> 'Użytkownik został usunięty!',
	'users.auth.errors.not_paid'	=> 'Konto nie zostało opłacone!',
	'users.auth.errors.other_error'	=> 'Wystąpił błąd!',
	
	'users.steps.login' => 'Logowanie użytkownika',
	'users.steps.register' => 'Rejestracja użytkownika',
	'users.steps.lost_password' => 'Przypomnienie hasła',
	
	'users.logged_as' => 'Jesteś zalogowany jako',
	
	'users.logout.btn' => 'Wyloguj',
	'users.logout.success' => 'Zostałeś wylogowany!',
	
	'users.login' => 'Zaloguj',
	'users.login.title' => 'Logowanie',
	'users.login.alert' => 'Musisz być zalogowany, aby korzystać z tej części serwisu.',
	'users.login.success' => 'Zostałeś zalogowany!',
	'users.login.already_logged' => 'Jesteś już zalogowany!',
	'users.login.info' => 
		'<div style="font-size: 22px">Dostęp tylko po <strong>zalogowaniu</strong>.</div>
		Jeśli nie posiadasz jeszcze konta - <a href=":register_url">zarejestruj się</a> (rejestracja zajmie Ci ok. 10-20 sekund).',
	
	'users.register.link' => 'Nie masz konta? :link',
	'users.register.link.title' => 'Zarejestruj się!',
	'users.register' => 'Rejestracja',
	'users.register.btn' => 'Zarejestruj',
	'users.register.title' => 'Rejestracja',
	'users.register.success' => array(
		NULL => 'Rejestracja została poprawnie zakończona!',
		'activate' => 'Zostałeś zarejestrowany! Sprawdź swój email aby potwierdzić konto.',
	),
	'users.register.info' => 'W celu rejestracji w systemie prosimy o wypełnienie poniższego formularza. Wszystkie pola są obowiązkowe.',
	
	'users.session.expired' => 'Twoja sesja wygasła!',
	'users.session.restored' => 'Zostałeś automatycznie zalogowany!',
	
	'users.forms.confirm_pass.error.compare' => 'Hasła są różne!',
	'users.forms.validator.auth.email.duplicate' => 'Ten adres e-mail już jest zarejestrowany!',
	'users.forms.validator.auth.user.password.error' => 'Wprowadzone hasło jest niepoprawne!',
	'users.forms.validator.auth.username.error' => 'Nieprawidłowa nazwa użytkownika! Dozwolone są tylko znaki alfanumeryczne, myślniki oraz podkreślenia.',
	'users.forms.validator.auth.username.error_length' => 'Nieprawidłowa nazwa użytkownika! Długość nazwy od :min do :max znaków.',
	'users.forms.validator.auth.username.error_invalid' => 'Niedozwolona nazwa użytkownika!',
	'users.forms.validator.auth.username.error_duplicate' => 'Już istnieje użytkownik z takim loginem!',
	
	'users.forms.validator.email.blacklist' => 'Ten adres e-mail znajduje się na czarnej liście!',
	
	'users.facebook.not_verified' => 'Tylko zweryfikowani użytkownicy Facebooka mogą się zalogować! 
		Dokończ weryfikację konta Facebook i spróbuj ponownie.',
	'users.facebook.register.title' => 'Rejestracja nowego konta',
	'users.facebook.register.success' => 'Zostałeś zarejestrowany oraz zalogowany!',
	'users.facebook.settings.enable' => 'Włącz logowanie Facebook',
	'users.facebook.settings.info' => 'Aby skorzystać z tej funkcjonalności musisz utworzyć nową aplikację Facebook, 
		a następnie wypełnić pola App ID i App Secret. :link',
	'users.facebook.settings.info.link' => 'Kliknij tutaj, aby przejść do panelu aplikacji Facebook',
	'users.facebook.login.btn' => 'Zaloguj z Facebook',
	
	'users.password_recovery.success' => 'Link do zresetowania hasła został wysłany na Twój email!',
	'users.password_recovery.error.not_found' => 'Nie znaleziono użytkownika z takim adresem e-mail!',

	'users.new_password.success' => 'Hasło zostało zmienione!',
	'users.new_password.error' => 'Wystąpił nieoczekiwany błąd. Spróbuj ponownie.',
	
	'users.activate.success' => 'Konto zostało aktywowane! Prosimy o uzupełnienie pozostałych danych profilowych.',
	'users.activate.error' => 'Wystąpił błąd podczas aktywacji konta! Skontaktuj się z administratorem.',
	
	'users.lost_password.link' => 'Zapomniałeś hasła?',
	'users.lost_password.title' => 'Odzyskiwanie hasła',
	'users.lost_password.success' => 'Instrukcje dotyczące przywrócenia hasła zostały wysłane na Twój adres e-mail.',
	'users.lost_password.error' => 'Nie znaleziono takiego adresu e-mail!',
	'users.lost_password.email.subject' => 'Przypomnienie hasła w serwisie',
	
	'users.new_password.title' => 'Nowe hasło',
	'users.new_password.success' => 'Nowe hasło zostało utworzone!',
	
	'users.send_activation_link.link' => 'Wyślij ponownie link rejestracji',
	'users.send_activation_link.title' => 'Wyślij ponownie link rejestracji',
	'users.send_activation_link.success' => 'Wiadomość została wysłana!',
	'users.send_activation_link.error' => 'Nie można wysłać linku aktywującego konto pod podany adres!',
	
	'bauth.payments.user.title' => 'Rejestracja użytkownika',
	'bauth.payments.user.description' => 'Rejestracja użytkownika: :user_name',
	'bauth.payments.user.enable' => 'Włączyć płatność za: :title',
	
	'user_id' => 'ID użytkownika',
	'user_name' => 'Nazwa użytkownika',
	'user_email' => 'Adres e-mail',
	'user_pass' => 'Hasło',
	'user_password' => 'Hasło',
	'user_pass2' => 'Powtórz hasło',
	'user_groups' => 'Grupy / uprawnienia',
	'users_data_person_type' => 'Osoba / Firma', 
	'users_data_person' => 'Imię i nazwisko/firma',
	'user_registration_date' => 'Data rejestracji',
	
	'users.remember' => 'Zapamiętaj mnie',
	
	'login_or_email' => 'Login lub e-mail',
	
	'users.forms.lost_password.submit' => 'Przypominj hasło',
	
	'users.forms.new_password.user_pass' => 'Nowe hasło',
	'users.forms.new_password.user_pass2' => 'Powtórz hasło',
	'users.forms.new_password.submit' => 'Resetuj hasło',
	
	'users.forms.send_activation_link.submit' => 'Wyślij link',
	
	'users.forms.change_password.old_pass' => 'Twoje aktualne hasło',
	'users.forms.change_password.user_pass' => 'Nowe hasło',
	'users.forms.change_password.user_pass2' => 'Powtórz nowe hasło',
	'users.forms.change_password.submit' => 'Zmień hasło',
	
	'profile.title' => 'Profil',
	'profile.settings.title' => 'Szczegółowe dane użytkownika',
	'profile.settings.success' => 'Dane zostały zaktualizowane!',
	'profile.settings.link' => 'Zmień ustawienia',
	
	'profile.change_password.title' => 'Zmień hasło',
	'profile.change_password.success' => 'Hasło zostało zmienione!',
	
	'profile.promotions.title' => 'Specjalne oferty',
	
	'profile.avatar.title' => 'Awatar',
	'users.forms.avatar.avatar' => 'Zmień awatar',
	'users.forms.avatar.avatar_info' => 'Plik graficzny o wymiarach 100x100 px.',
	
	/**
	 * ADMIN
	 */
	
	'users.admin.menu.browse' => 'Przeglądaj użytkowników',
	'users.admin.menu.add' => 'Dodaj użytkownika',
	'users.admin.menu.settings' => 'Ustawienia użytkowników',
	'users.admin.menu.blacklist' => 'Czarna lista e-mail',
	'users.admin.menu.blacklist.index' => 'Przeglądaj czarną listę',
	'users.admin.menu.blacklist.add' => 'Dodaj e-mail do blokowanych',
	
	'users.admin.stats.title' => 'Statystyki użytkowników',
	'users.admin.stats.normal_count' => 'Zwykłych użytkowników',
	'users.admin.stats.not_active_count' => 'Niepotwierdzonych rejestracji',
	'users.admin.stats.count' => 'Ogółem użytkowników',
	
	'users.admin.table.promotions' => 'promocje',
	
	'users.admin.payments.title' => 'Płatności użytkowników',
	'users.admin.payments.success' => 'Zmiany zostały zapisane!',
	
	'users.admin.settings.title' => 'Ustawienia użytkowników',
	'users.admin.settings.success' => 'Zmiany zostały zapisane!',
	
	'users.admin.add.title' => 'Dodawanie użytkownika',
	'users.admin.add.success' => 'Użytkownik został dodany!',
	
	'users.admin.edit.title' => 'Edycja użytkownika',
	'users.admin.edit.success' => 'Zmiany zostały zapisane!',
	
	'users.admin.delete.success' => 'Użytkownik został usunięty!',
	
	'users.admin.activate.success' => 'Użytkownik został aktywowany!',
	
	'users.admin.promotions.title' => 'Promocje',
	'users.admin.promotions.success' => 'Zmiany zostały zapisane!',
	
	'users.admin.send_promotions.title' => 'Wyślij wiadomość ze zmianami w promocjach użytkownika',
	'users.admin.send_promotions.success' => 'Wiadomość została wysłana!',
	
	'users.admin.blacklist.index.title' => 'Zablokowane adresy e-mail',
	'users.admin.blacklist.add.title' => 'Dodaj adres e-mail do zablokowanych',
	'users.admin.blacklist.add.success' => 'Adres e-mail został dodany do zablokowanych!',
	'users.admin.blacklist.edit.title' => 'Edytuj zablokowany adres e-mail',
	'users.admin.blacklist.edit.success' => 'Zablokowany adres e-mail został zmieniony!',
	'users.admin.blacklist.delete.success' => 'Adres e-mail został usunięty z zablokowanych!',
	
	'users.admin.admins.title' => 'Administratorzy',
	'users.admin.admins.index.menu' => 'Przeglądaj administratorów',
	'users.admin.admins.index.title' => 'Przeglądaj administratorów',
	'users.admin.admins.add.menu' => 'Dodaj administratora',
	'users.admin.admins.add.title' => 'Dodaj administratora',
	'users.admin.admins.add.success' => 'Administrator został dodany!',
	'users.admin.admins.edit.title' => 'Edytuj administratora',
	'users.admin.admins.edit.success' => 'Zmiany zostały zapisane!',
	'users.admin.admins.delete.success' => 'Administrator został usunięty!',
	
	'users.admin.groups.title' => 'Grupy',
	'users.admin.groups.group_name' => 'Nazwa grupy',
	'users.admin.groups.index.menu' => 'Przeglądaj grupy',
	'users.admin.groups.index.title' => 'Przeglądaj grupy',
	'users.admin.groups.add.menu' => 'Dodaj grupę',
	'users.admin.groups.add.title' => 'Dodaj grupę',
	'users.admin.groups.add.success' => 'Grupa została dodana!',
	'users.admin.groups.edit.title' => 'Edytuj grupę',
	'users.admin.groups.edit.success' => 'Zmiany zostały zapisane!',
	'users.admin.groups.delete.success' => 'Grupa została usunięta!',
	'users.admin.groups.form.group_name' => 'Nazwa grupy',
	'users.admin.groups.form.group_description' => 'Opis grupy',
	'users.admin.groups.form.group_is_admin' => 'Grupa z dostępem do panelu administratorskiego',
	'users.admin.groups.permissions.btn' => 'zarządzaj uprawnieniami',
	'users.admin.groups.permissions.title' => 'Zarządzanie uprawnieniami',
	'users.admin.groups.permissions.success' => 'Zmiany zostały zapisane!',
	
	'bauth/frontend/auth/login' => 'logowanie-uzytkownika',
	'bauth/frontend/auth/register' => 'rejestracja',
	'bauth/frontend/auth/logout' => 'wyloguj',
	'bauth/frontend/auth/new_password' => 'nowe-haslo/<hash>',
	'bauth/frontend/auth/activate' => 'aktywacja-uzytkownika/<hash>',
	'bauth/frontend/auth/lost_password' => 'zgubione-haslo',
	'bauth/frontend/auth/send_activation_link' => 'auth/send_activation_link',
	'bauth/frontend/facebook/login' => 'facebook/logowanie',
	'bauth/frontend/facebook/register' => 'facebook/nowe-konto',
	'site_profile/profile/settings/change' => 'profil/ustawienia/zmien',
	'site_profile/frontend/profile/index' => 'profil',
);