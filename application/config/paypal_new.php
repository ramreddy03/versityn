<?php
/** set your paypal credential **/

$config['client_id'] = 'Afk0WdYQ2-BBAmsTt16Id4APPvrywO-5eB2oVLmIIbf_JRZ3-ZK1fLrCJxcTV47bxvDBvMB5BQOlhY_y';
$config['secret'] = 'EOzi_DF5yKicS6LyASjWTDkJFPJupyh5xoeTP-H-T84OeJuc2J39cXZAQD3-C_93RJS7EqKup4Z_KlEQ';

/**
 * SDK configuration
 */
/**
 * Available option 'sandbox' or 'live'
 */
$config['settings'] = array(

    'mode' => 'sandbox',
    /**
     * Specify the max request time in seconds
     */
    'http.ConnectionTimeOut' => 1000,
    /**
     * Whether want to log to a file
     */
    'log.LogEnabled' => true,
    /**
     * Specify the file that want to write on
     */
    'log.FileName' => 'application/logs/paypal.log',
    /**
     * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
     *
     * Logging is most verbose in the 'FINE' level and decreases as you
     * proceed towards ERROR
     */
    'log.LogLevel' => 'FINE'
);
