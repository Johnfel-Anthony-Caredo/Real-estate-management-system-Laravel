<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Admin triggers
        DB::statement("
            CREATE TRIGGER after_admin_insert AFTER INSERT ON admins FOR EACH ROW
            BEGIN
                INSERT INTO admin_logs (admin_id, operation, changed_data, performed_at)
                VALUES (NEW.id, 'INSERT', CONCAT('Added new admin with ID: ', NEW.id), NOW());
            END
        ");

        DB::statement("
            CREATE TRIGGER after_admin_update AFTER UPDATE ON admins FOR EACH ROW
            BEGIN
                INSERT INTO admin_logs (admin_id, operation, changed_data, performed_at)
                VALUES (NEW.id, 'UPDATE', CONCAT('Admin data updated for ID: ', NEW.id), NOW());
            END
        ");

        DB::statement("
            CREATE TRIGGER after_admin_delete AFTER DELETE ON admins FOR EACH ROW
            BEGIN
                INSERT INTO admin_logs (admin_id, operation, changed_data, performed_at)
                VALUES (OLD.id, 'DELETE', CONCAT('Deleted admin with ID: ', OLD.id), NOW());
            END
        ");

        // Property triggers
        DB::statement("
            CREATE TRIGGER after_prop_insert AFTER INSERT ON props FOR EACH ROW
            BEGIN
                INSERT INTO prop_logs (prop_id, operation, changed_data, performed_at)
                VALUES (NEW.id, 'INSERT', CONCAT('Added new property with ID: ', NEW.id), NOW());
            END
        ");

        DB::statement("
            CREATE TRIGGER after_prop_update AFTER UPDATE ON props FOR EACH ROW
            BEGIN
                INSERT INTO prop_logs (prop_id, operation, changed_data, performed_at)
                VALUES (NEW.id, 'UPDATE', CONCAT('Property data updated for ID: ', NEW.id), NOW());
            END
        ");

        DB::statement("
            CREATE TRIGGER after_prop_delete AFTER DELETE ON props FOR EACH ROW
            BEGIN
                INSERT INTO prop_logs (prop_id, operation, changed_data, performed_at)
                VALUES (OLD.id, 'DELETE', CONCAT('Deleted property with ID: ', OLD.id), NOW());
            END
        ");

        // User triggers
        DB::statement("
            CREATE TRIGGER after_user_insert AFTER INSERT ON users FOR EACH ROW
            BEGIN
                INSERT INTO user_logs (user_id, operation, changed_data, performed_at)
                VALUES (NEW.id, 'INSERT', CONCAT('Added new user with ID: ', NEW.id), NOW());
            END
        ");

        DB::statement("
            CREATE TRIGGER after_user_update AFTER UPDATE ON users FOR EACH ROW
            BEGIN
                INSERT INTO user_logs (user_id, operation, changed_data, performed_at)
                VALUES (NEW.id, 'UPDATE', CONCAT('User data updated for ID: ', NEW.id), NOW());
            END
        ");

        DB::statement("
            CREATE TRIGGER after_user_delete AFTER DELETE ON users FOR EACH ROW
            BEGIN
                INSERT INTO user_logs (user_id, operation, changed_data, performed_at)
                VALUES (OLD.id, 'DELETE', CONCAT('Deleted user with ID: ', OLD.id), NOW());
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop triggers in reverse order
        DB::statement("DROP TRIGGER IF EXISTS after_user_delete");
        DB::statement("DROP TRIGGER IF EXISTS after_user_update");
        DB::statement("DROP TRIGGER IF EXISTS after_user_insert");
        
        DB::statement("DROP TRIGGER IF EXISTS after_prop_delete");
        DB::statement("DROP TRIGGER IF EXISTS after_prop_update");
        DB::statement("DROP TRIGGER IF EXISTS after_prop_insert");
        
        DB::statement("DROP TRIGGER IF EXISTS after_admin_delete");
        DB::statement("DROP TRIGGER IF EXISTS after_admin_update");
        DB::statement("DROP TRIGGER IF EXISTS after_admin_insert");
    }
};