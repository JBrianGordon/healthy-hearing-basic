<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddOticonAndSimulatorBadgesToLocations extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('locations');
        $table->addColumn('badge_oticon_foundation', 'boolean', [
                'default' => false,
                'null' => false,
                'after' => 'badge_ear_cleaning',
            ]);
        $table->addColumn('badge_hearing_simulator', 'boolean', [
                'default' => false,
                'null' => false,
                'after' => 'badge_oticon_foundation',
        ]);
        $table->save();
    }

    public function down(): void
    {
        $table = $this->table('locations');
        $table->removeColumn('badge_oticon_foundation');
        $table->removeColumn('badge_hearing_simulator');
        $table->save();
    }
}
