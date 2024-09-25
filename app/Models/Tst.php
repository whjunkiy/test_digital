<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tst extends Model
{
    protected $table = 'tst';

    protected $fillable = [
        'track_id', 'isrc',	'track_external_id',	'album_id',	'album_external_id',	'title',	'version',	'artist',	'album', 'file',
    ];

    public static function getFiles(){
        return DB::table('tst')
            ->selectRaw('DISTINCT file')
            ->get();
    }

    public static function getDubls(){
        return DB::table('tst')
            ->selectRaw('isrc, artist, title, album, COUNT(*)')
            ->groupBy(['isrc', 'artist', 'title', 'album'])
            ->havingRaw('COUNT(*) > ?', [1])
            ->get();
    }

    public static function getDif($f1, $f2){
        return DB::select('SELECT * FROM "public"."tst" WHERE "file" = :f1 AND "id" NOT IN (
SELECT
  "t1"."id"
FROM
"public"."tst" as "t1"
INNER JOIN
(SELECT * FROM "public"."tst" WHERE "file" = :f2) as "t2"
ON "t1"."isrc" = "t2"."isrc"
WHERE "t1"."file" = :f1)', [
            'f1' => $f1,
            'f2' => $f2,
        ]);
    }
}
