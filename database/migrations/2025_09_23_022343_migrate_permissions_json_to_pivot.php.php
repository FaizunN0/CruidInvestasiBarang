<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('permissions') || !Schema::hasTable('users')) return;

        $users = DB::table('users')->select('id','permissions')->get();
        foreach ($users as $u) {
            if (empty($u->permissions)) continue;
            $perms = json_decode($u->permissions, true);
            if (!is_array($perms)) continue;
            foreach ($perms as $permName) {
                $perm = DB::table('permissions')->where('name',$permName)->first();
                if ($perm) {
                    DB::table('permission_user')->updateOrInsert(
                        ['user_id'=>$u->id,'permission_id'=>$perm->id],
                        ['created_at'=>now(),'updated_at'=>now()]
                    );
                }
            }
        }
    }

    public function down(): void {
        // no-op
    }
};
