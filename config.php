<?php
    include "data.php";

    function getArr($ga)
    {
        $ga = htmlspecialchars_decode($ga);
        $ga = preg_replace("/^\s/", "", $ga);
        $arr = explode("\n", $ga);
        $newArr = [];
        if(count($arr) > 0)
        {
            foreach($arr as $a)
            {
                if(!empty($a)) $newArr[] = $a;
            }
        }
        return $newArr;
    }

    function post($url, $data = [])
    {
        $headers = ["Content-Type: application/json", "accept: application/json"];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    function b64ToImg($b64, $file) 
    {
        $ifp = fopen($file, "wb");
        $data = explode(',', $b64);
        fwrite($ifp, base64_decode($data[1]));
        fclose($ifp);
        return $file;
    }

    function csv( $create_data, $file = null, $col_delimiter = ';', $row_delimiter = "\r\n" )
    {

        if( ! is_array($create_data) )
            return false;

        $CSV_str = '';

        // перебираем все данные
        foreach($create_data as $row)
        {
            $cols = [];

            foreach($row as $col_val)
            {
                // строки должны быть в кавычках ""
                // кавычки " внутри строк нужно предварить такой же кавычкой "
                if( $col_val && preg_match('/[",;\r\n]/', $col_val) ){
                    // поправим перенос строки
                    if( $row_delimiter === "\r\n" ){
                        $col_val = str_replace( "\r\n", '\n', $col_val );
                        $col_val = str_replace( "\r", '', $col_val );
                    }
                    elseif( $row_delimiter === "\n" ){
                        $col_val = str_replace( "\n", '\r', $col_val );
                        $col_val = str_replace( "\r\r", '\r', $col_val );
                    }

                    $col_val = str_replace( '"', '""', $col_val ); // предваряем "
                    $col_val = '"'. $col_val .'"'; // обрамляем в "
                }

                if(empty($col_val)) $col_val = "";
                $cols[] = $col_val; // добавляем колонку в данные
            }

            $CSV_str .= implode( $col_delimiter, $cols ) . $row_delimiter; // добавляем строку в данные
        }

        $CSV_str = rtrim($CSV_str, $row_delimiter);

        // задаем кодировку windows-1251 для строки
        if($file)
        {
            // $CSV_str = iconv( "UTF-8", "cp1251",  $CSV_str );

            // создаем csv файл и записываем в него строку
            $done = file_put_contents( $file, $CSV_str );

            return $done ? $CSV_str : false;
        }

        // return $CSV_str;

    }

?>