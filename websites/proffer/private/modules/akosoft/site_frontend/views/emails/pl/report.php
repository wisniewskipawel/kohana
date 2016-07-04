Witaj,
<br/><br/>
Zostało zgłoszone naruszenie zasad dla wpisu "<?php echo HTML::chars($report_name) ?>" znajdującego się pod poniższym linkiem:<br/>
<?php echo $report_anchor ?><br/>
<br/>

<?php if(isset($reason)): ?>
Powód zgłoszenia:<br/>
<p><?php echo HTML::chars($reason); ?></p>
<?php endif; ?>

Zgłosił: <?php echo ($user AND $user->loaded()) ? $user->user_name : 'Gość' ?> 

<?php if(isset($email)): ?>
<<?php echo HTML::mailto($email) ?>><br/>
<?php endif; ?>

IP: <?php echo HTML::chars(Request::$client_ip) ?><br/>