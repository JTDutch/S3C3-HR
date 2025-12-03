<?php

namespace App\Models;

use CodeIgniter\Model;

class SetlistModel extends Model
{
    public function get_all()
    {
        return $this->db->query("SELECT * FROM `setlist` WHERE `deleted_at` = '0000-00-00 00:00:00' ORDER BY `show_date` ASC")->getResult();
    }

    public function add_song($spotify_link, $name)
    {
        $this->db->query("
            INSERT INTO `setlist`
            (`spotify_link`, `name`)
            VALUES (?, ?)",
            array(
                $spotify_link,
                $name
            )
        );

        return $this->db->affectedRows() > 0;
    }

}