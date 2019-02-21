<?php
namespace common\mad;

use yii\base\Component;
use yii\db\MigrationInterface;

class Migration extends Component implements MigrationInterface {

    public function init() {
        parent::init();
    }

    /**
     * This method contains the logic to be executed when applying this migration.
     * Child classes may override this method to provide actual migration logic.
     *
     * @return boolean return a false value to indicate the migration fails
     *         and should not proceed further. All other return values mean the migration succeeds.
     */
    public function up() {
    }

    /**
     * This method contains the logic to be executed when removing this migration.
     * The default implementation throws an exception indicating the migration cannot be removed.
     * Child classes may override this method if the corresponding migrations can be removed.
     *
     * @return boolean return a false value to indicate the migration fails
     *         and should not proceed further. All other return values mean the migration succeeds.
     */
    public function down() {
    }
}
