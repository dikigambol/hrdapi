<?php
    date_default_timezone_set('Asia/Jakarta');
    //----------------------------- Host -----------------------------//
    $join_log_n_user='SELECT db_asia.log_letter.id, db_asia.log_letter.Log_id, db_asia.log_letter.Log_date, db_asia.log_letter.Log_action, db_administrator.user_entity.user_name FROM db_asia.log_letter INNER JOIN db_administrator.user_entity on db_asia.log_letter.id = db_administrator.user_entity.id';
    //$host_clien='localhost:3000/';
    
    //----------------------------- Directory -----------------------------//
    //---- 1. Surat ----//
    

