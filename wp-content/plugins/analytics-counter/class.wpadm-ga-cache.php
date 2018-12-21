<?php
class Wpadm_GA_Cache {
    
    static function getCache() {
        global $wpdb;

        check_ajax_referer('wpadm_ga_cache_security', 'security');

        $query = $_POST['query'];

        if (!$query || !is_array($query)) {
            wp_die();
        }
        $table_name = self::getTableName();

        ksort($query);
        $query = json_encode($query);

        $request_type = filter_input(INPUT_POST, 'request_type', FILTER_SANITIZE_STRING);
        $object_type = filter_input(INPUT_POST, 'object_type', FILTER_SANITIZE_STRING);

        
        $sql = $wpdb->prepare(
            "SELECT 
                html, result 
            FROM 
                {$table_name} 
            WHERE 
                `query`= '%s' 
                AND `object_type`='%s' 
                AND `request_type`='%s' 
                AND (expired_in =0 OR expired_in > %d) 
            ",
            $query,
            $object_type,
            $request_type,
            time()
        );

        $rows = $wpdb->get_results($sql, ARRAY_A);
        if($rows) {
            echo json_encode(
                array(
                    'status' => 'success',
                    'html'   => stripslashes($rows[0]['html']),
                    'result' => stripslashes($rows[0]['result']),
                )
            );
        } else {
            echo json_encode(
                array(
                    'status' => 'empty'
                )
            );
        }

        wp_die();
    }

    static function setCache() {
        global $wpdb;

        check_ajax_referer('wpadm_ga_cache_security', 'security');

        $query = $_POST['query'];
        if (!$query || !is_array($query)) {
            wp_die();
        }

        $table_name = self::getTableName();
        ksort($query);

        $request_type = filter_input(INPUT_POST, 'request_type', FILTER_SANITIZE_STRING);
        $html = filter_input(INPUT_POST, 'html', FILTER_SANITIZE_STRING);
        $result = json_encode($_POST['result']);
        $object_type = filter_input(INPUT_POST, 'object_type', FILTER_SANITIZE_STRING);

        if (isset($query['metrics']) && is_array($query['metrics'])) {
            $query['metrics'] = implode(',', $query['metrics']);
        }
        if (isset($query['dimensions']) && is_array($query['dimensions'])) {
            $query['dimensions'] = implode(',', $query['dimensions']);
        }
        if (isset($query['sort']) && is_array($query['sort'])) {
            $query['sort'] = implode(',', $query['sort']);
        }

        $start_date_plus_day = new DateTime($query['start-date'] . '00:00:00');
        $start_date_plus_day = new DateTime(date("Y-m-d",strtotime("+1 day", $start_date_plus_day->format('U'))) . ' 00:00:00');

        $end_date = new DateTime($query['end-date'] . '23:59:59');
        $now = new DateTime();
        $expired_in = 0;

        if ($end_date->format("Ymd") > $now->format('Ymd')) {

            $now_plus_day = new DateTime(date("Y-m-d",strtotime("+1 day")) . ' 00:00:00');

            $e_in = max($start_date_plus_day->format("Y-m-d"), $now_plus_day->format("Y-m-d"));
            $e_in = new DateTime($e_in);
            $expired_in = $e_in->format('U');
        } elseif ($end_date->format("Ymd") == $now->format('Ymd')) {
            $expired_in = $now->format('U');
        }


        $query = json_encode($query);

        //заменить на insert ignore
        $sql = $wpdb->prepare(
            "DELETE FROM {$table_name} WHERE `query`= '%s' AND `object_type`='%s' AND `request_type`='%s'",
            $query,
            $object_type,
            $request_type
        );
        $wpdb->query($sql);
        
        $sql = $wpdb->prepare(
            "
                INSERT INTO {$table_name}
                  (`query`, `html`, `result`, `request_type`, `object_type`, `expired_in`)
                VALUES
                  ('%s', '%s', '%s', '%s', '%s', '%d')
		        ",
            $query,
            $html,
            $result,
            $request_type,
            $object_type,
            $expired_in
            
        );
        $wpdb->query($sql);

        echo json_encode(array(
            'status' => 'success'
        ));


        wp_die();

    }

    static protected function getTableName() {
        global $wpdb;
        return $wpdb->prefix . "wpadm_ga_cache";
    }


    static public function cronRemoveExpiredCache() {
        global $wpdb;
        $table_name = self::getTableName();
        $sql = $wpdb->prepare(
            "DELETE FROM {$table_name} WHERE expired_in != 0 AND expired_in < '%d'",
            time()
        );
        $wpdb->query($sql);
    } 

    static public function clear() {
        global $wpdb;
        $table_name = self::getTableName();
        $sql = "DELETE FROM {$table_name}";
        $wpdb->query($sql);

    }

}