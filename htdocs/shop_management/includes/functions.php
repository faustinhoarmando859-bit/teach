<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
function e($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function require_login(){ if(empty($_SESSION['user_id'])) { header('Location: login.php'); exit; } }
function money($n){ return 'TZS '.number_format((float)$n,2); }
function flash($msg,$type='success'){ $_SESSION['flash']=['msg'=>$msg,'type'=>$type]; }
function get_flash(){ if(empty($_SESSION['flash'])) return ''; $f=$_SESSION['flash']; unset($_SESSION['flash']); return '<div class="alert alert-'.e($f['type']).' alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>'.e($f['msg']).'</div>'; }
