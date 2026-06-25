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
        // Create DeleteUser stored procedure
        DB::unprepared('
            DROP PROCEDURE IF EXISTS DeleteUser;
            
            CREATE PROCEDURE DeleteUser(IN userId INT)
            BEGIN
                -- We want to keep the logs even after user deletion
                -- So we don\'t delete anything from user_logs table
                
                -- Delete the user if they exist
                DELETE FROM users WHERE id = userId;
            END
        ');
        
        // Create DeleteAdmin stored procedure
        DB::unprepared('
            DROP PROCEDURE IF EXISTS DeleteAdmin;
            
            CREATE PROCEDURE DeleteAdmin(IN adminId INT, OUT status VARCHAR(100))
            BEGIN
                DECLARE adminCount INT;
                DECLARE currentAdminId INT;
                
                -- Start transaction for data integrity
                START TRANSACTION;
                
                -- Check if this is the only admin
                SELECT COUNT(*) INTO adminCount FROM admins;
                
                IF adminCount <= 1 THEN
                    SET status = "ERROR: Cannot delete the only admin account";
                    ROLLBACK;
                ELSE
                    -- Delete admin logs first
                    DELETE FROM admin_logs WHERE admin_id = adminId;
                    
                    -- Delete the admin
                    DELETE FROM admins WHERE id = adminId;
                    
                    SET status = "SUCCESS: Admin deleted successfully";
                    COMMIT;
                END IF;
            END
        ');
        
        // Create GetUserProperties stored procedure
   
        
        // You can add more procedures here in the future
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop all procedures in reverse order
        DB::unprepared('DROP PROCEDURE IF EXISTS GetUserProperties');
        DB::unprepared('DROP PROCEDURE IF EXISTS DeleteAdmin');
        DB::unprepared('DROP PROCEDURE IF EXISTS DeleteUser');
    }
};