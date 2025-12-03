<?php

function debug($var, $die = false)
{
    echo "<pre>";
    print_r($var);
    echo "<hr />";
    echo "</pre>";
    if ($die) {
        die();
    }
}


if (!function_exists('load_css')) {
    function load_css($assets)
    {
        $str        = '';
        $path       = base_url() . '/assets/css/';
        foreach ($assets as $item) {
            $str .= '<link rel="stylesheet" href="' . $path . $item . '?v=' . getenv('CSS_VERSION') . '" type="text/css" />' . "\n";
        }

        return $str;
    }
}

if (!function_exists('load_js')) {
    function load_js($assets)
    {
        $str        = '';
        $path       = base_url() . '/assets/js/';
        foreach ($assets as $item) {
            $str .= "<script type=\"text/javascript\" src=\"".$path. $item . "?v=" . getenv('JS_VERSION') . "\"></script>" . "\n";
        }
        return $str;
    }
}


if (!function_exists("prepare_datatable_query")) {
    /**
     * Prepare current GET data for easy filtering and sorting for a jQuery datatable.
     * @param array $table_columns Table column definitions, options include: column, sort_column, comparison, comparison_format, encrypted, filter
     * @param array $parameters The current get parameters
     * @param array $query_statements Default query statements
     * @param array $query_parameters Default query parameters
     * @param array $sort_columns Default sort columns
     *
     * @return mixed
     */
    function prepare_datatable_query(array $table_columns, array $parameters, array $query_statements = array(), array $query_parameters = array(), array $sort_columns = array())
    {
        foreach ($table_columns as $column) {
            // Check if we need to filter
            if (isset($column->filter) && $column->filter) {
                // Prepare encryption if needed
                if (isset($column->encrypted) && $column->encrypted) {
                    $column->column = AES_DECRYPT($column->column, false);
                    if (isset($column->sort_column)) {
                        $column->sort_column = AES_DECRYPT($column->sort_column, false);
                    }
                }
                // Like comparison, options:
                // {0}      = LIKE 'a'
                // %{0}     = LIKE '%a'
                // {0}%     = LIKE 'a%'
                // %{0}%    = LIKE '%a%' (Default)
                if ($column->comparison == "LIKE") {
                    $query_statements[] = "AND {$column->column} LIKE ?";
                    $query_parameters[] = str_replace("{0}", $column->filter, $column->comparison_format ?? "%{0}%");
                }
                // Equals comparison (Also used for NULL AND NOT NULL)
                elseif ($column->comparison == "EQUALS") {
                    // IS NULL comparison
                    if ($column->filter == "IS_NULL") {
                        $query_statements[] = "AND {$column->column} IS NULL";
                    }
                    // IS NOT NULL comparison
                    elseif ($column->filter == "IS_NOT_NULL") {
                        $query_statements[] = "AND {$column->column} IS NOT NULL";
                    }
                    // Default comparison
                    else {
                        $query_statements[] = "AND {$column->column} = ?";
                        $query_parameters[] = $column->filter;
                    }
                }
                // In comparison
                elseif ($column->comparison == "IN") {
                    $query_statements[] = "AND {$column->column} IN ?";
                    $query_parameters[] = explode(",", $column->filter);
                }
            }
        }
        // Prepare sorting
        for ($i = 0; $i < $parameters["iSortingCols"]; $i++) {
            $sortColumn     = $table_columns[$parameters["iSortCol_{$i}"]]->sort_column ?? $table_columns[$parameters["iSortCol_{$i}"]]->column;
            $sort_columns[] = $sortColumn . " " . strtoupper($parameters["sSortDir_{$i}"]);
        }
        return (object) [
            "query_statements"  => $query_statements,
            "query_parameters"  => $query_parameters,
            "sort"              => implode(", ", $sort_columns),
            "pagination_start"  => (int) $parameters["iDisplayStart"],
            // "pagination_amount" => (int) $parameters["iDisplayLength"],
            "pagination_amount" => (int) 10,
        ];
    }
}


