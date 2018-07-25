<?php

namespace App\Models\Tools;

class Common
{
    /**
     *
     * Get times as option-list.
     *
     * @return string List of times
     */
    public static function get_times($default = '19:00', $interval = '+30 minutes', $selected = "")
    {
        $output = '';

        $current = strtotime( '00:00' );
        $end = strtotime( '23:59' );

        while ( $current <= $end ) {
            $time = date( 'H:i', $current );

            if (empty($selected)) {
				$sel = ( $time == $default ) ? ' selected' : '';
			} else {
				$sel = ( $time == $default ) ? ' selected' : '';
			}

			$output .= "<option value=\"{$time}\"{$sel}>" . date( 'H:i', $current ) .'</option>';
            $current = strtotime( $interval, $current );
        }

        return $output;
    }
}
