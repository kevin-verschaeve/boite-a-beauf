<?php

namespace BAB\Manager;

use BAB\Builder\SoundBuilder;
use BAB\Model\Sound;

class SoundManager
{
    /** @var SqliteManager */
    private $manager;

    public function __construct(SqliteManager $manager)
    {
        $this->manager = $manager;
    }

    public function findAll(bool $onlyEnabled = true)
    {
        $sql = 'SELECT id, label, publicPath, isRecord FROM sound';

        if (true === $onlyEnabled) {
            $sql .= ' WHERE isEnabled = 1;';
        }

        return $this->manager->query($sql, [], Sound::class);
    }

    public function findRandom(): ?Sound
    {
        $sql = 'SELECT s.id, s.label, s.publicPath, s.isRecord FROM sound s LEFT JOIN played p ON s.id = p.sound_id WHERE p.id IS NULL ORDER BY RANDOM() LIMIT 1;';

        return $this->manager->queryRow($sql, [], Sound::class);
    }

    public function findOneLike(string $part): Sound
    {
        $sql = "SELECT id, label, publicPath, isRecord FROM sound WHERE label LIKE :part;";

        $result = $this->manager->query($sql, ['part' => "%$part%"], Sound::class);

        if (0 === count($result)) {
            throw new \Exception("$part, Aucun son trouvé.");
        }

        if (count($result) > 1) {
            throw new \Exception("$part, Plusieurs sons trouvés");
        }

        return $result[0];
    }

    public function insert(Sound $sound): bool
    {
        $sql = 'INSERT INTO sound (`label`, `publicPath`, `createdAt`, `isRecord`) VALUES (:label, :publicPath, :createdAt, :isRecord);';

        return $this->manager->insert($sql, [
            'label' => $sound->label,
            'publicPath' => $sound->publicPath,
            'isRecord' => $sound->isRecord,
            'createdAt' => (new \DateTime())->format('Y-m-d H:i:s'),
        ]);
    }
}
