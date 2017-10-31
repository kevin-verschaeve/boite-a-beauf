<?php

namespace BAB\Manager;

use BAB\Model\Sound;

class PlayedManager
{
    /** @var SqliteManager */
    private $manager;

    public function __construct(SqliteManager $manager)
    {
        $this->manager = $manager;
    }

    public function insert(Sound $sound)
    {
        $sql = 'INSERT INTO played (`sound_id`) VALUES (:sound_id);';

        return $this->manager->insert($sql, ['sound_id' => $sound->id]);
    }

    public function countPlayed()
    {
        $sql = 'SELECT COUNT(id) AS count FROM played;';

        return $this->manager->queryRow($sql)->count;
    }

    public function removeLast()
    {
        $sql = 'DELETE FROM played WHERE id = (SELECT MIN(id) FROM played);';

        return $this->manager->query($sql);
    }
}
