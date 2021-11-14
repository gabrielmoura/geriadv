<?php

namespace App\Actions\Client;

use Illuminate\Support\Facades\DB;

class TemporaryTable
{

    public function invoke($error)
    {
        //  Example in https://laracasts.com/discuss/channels/laravel/how-to-implement-temporary-table
        $dropTempTables = DB::unprepared(
            DB::raw("
                DROP TABLE IF EXISTS table_temp_a ;
                DROP TABLE IF EXISTS table_temp_b ;
            ")
        );
        $createTempTables = DB::unprepared(
            DB::raw("
                CREATE TEMPORARY TABLE table_temp_a
                                AS (
                                    SELECT
                                        parcel_id,
                                        sum(amount) as amount
                                    FROM cost_items
                                    WHERE expense_category_id = 9
                                    GROUP BY parcel_id
                                    );
                                CREATE TEMPORARY TABLE table_temp_b
                                AS (
                                    SELECT
                                        parcel_id,
                                        sum(amount) as amount
                                    FROM cost_items
                                    WHERE expense_category_id = 9
                                    GROUP BY parcel_id
                                    );

            ")
        );
        if ($createTempTables) {
            $medianData = DB::
            select(
                DB::raw("
                                SELECT
                                p.id
                                nc.median_category_9_cost

                        FROM programs p
                        LEFT JOIN(
                            SELECT
                                avg(t1.amount) AS median_category_9_cost
                            FROM
                                (
                                    SELECT
                                        @rownum :=@rownum + 1 AS `row_number` ,
                                    d.amount
                                    FROM
                                        table_temp_a d,
                                    (SELECT @rownum := 0) r
                                    WHERE
                                        1
                                    ORDER BY
                                        d.amount
                                ) AS t1 ,

                                (
                                    SELECT
                                        count(*) AS total_rows
                                    FROM
                                        table_temp_b d
                                    WHERE
                                        1

                                ) AS t2

                                WHERE
                                    1
                                AND t1.row_number
                                    IN(
                                        floor((t2.total_rows + 1) / 2) ,
                                        floor((t2.total_rows + 2) / 2)
                                    )

                                )nc on 1 = 1
            "));
        } else {
            // $error = "ERROR MESSAGE";
            // dd($error);
        }
    }
}
