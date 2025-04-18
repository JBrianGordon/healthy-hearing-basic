<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AlterReviewNeededOnLocations extends AbstractMigration
{
    public function up(): void
    {
        $locationsTable = $this->table('locations');
        $locationsTable->changeColumn('review_needed', 'boolean', [
            'default' => false,
            'limit' => null,
            'null' => false,
        ]);
        $locationsTable->update();

        $importDiffsTable = $this->table('import_diffs');
        $importDiffsTable->changeColumn('review_needed', 'boolean', [
            'default' => false,
            'limit' => null,
            'null' => false,
        ]);
        $importDiffsTable->update();
    }

    public function down(): void
    {
        $locationsTable = $this->table('locations');
        $locationsTable->changeColumn('review_needed', 'integer', [
            'default' => '0',
            'limit' => null,
            'null' => true,
        ]);
        $locationsTable->update();
        
        $importDiffsTable = $this->table('import_diffs');
        $importDiffsTable->changeColumn('review_needed', 'integer', [
            'default' => '0',
            'limit' => null,
            'null' => true,
        ]);
        $importDiffsTable->update();
    }
}
