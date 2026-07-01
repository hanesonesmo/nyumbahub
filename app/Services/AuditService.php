<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Request;

class AuditService
{
    /**
     * Log an action to the audit logs.
     *
     * @param string $action       e.g., 'Created', 'Updated', 'Deleted', 'Logged In'
     * @param string $module       e.g., 'Listing', 'User', 'AgentApplication'
     * @param string $description  Detailed description of the event.
     * @param string|null $record_id ID of the affected record, if applicable.
     */
    public static function log(string $action, string $module, string $description, ?string $record_id = null)
    {
        $user = auth()->user();
        
        $role = null;
        if ($user) {
            $role = $user->role;
        } elseif (session('admin_logged_in')) {
            $role = 'admin';
        } else {
            $role = 'guest';
        }

        try {
            AuditLog::create([
                'user_id'     => $user ? $user->id : null,
                'role'        => $role,
                'action'      => $action,
                'module'      => $module,
                'description' => $description,
                'record_id'   => $record_id,
                'ip_address'  => Request::ip(),
                'user_agent'  => Request::userAgent(),
            ]);
        } catch (\Exception $e) {
            // Silently fail if the audit_logs table does not exist yet (e.g. pending migrations)
            \Illuminate\Support\Facades\Log::warning('Audit logging failed: ' . $e->getMessage());
        }
    }
}
