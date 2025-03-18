<?php
namespace App\Helpers;

class ServerLoadHelper
{
    public static function isHighLoad()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Windows-based load calculation
            $load = exec('wmic cpu get loadpercentage /value');
            preg_match('/\d+/', $load, $matches);
            $cpuLoad = $matches[0] ?? 0;
            return $cpuLoad > 50; // High load if CPU > 50%
        } else {
            // Unix-based load calculation
            $load = sys_getloadavg(); // Get system load
            $cpuCount = shell_exec('nproc'); // Get number of CPU cores

            if ($load[0] > ($cpuCount * 0.5)) {
                // If load in the last minute > 50% of CPU capacity = High Load
                return true;
            }
        }

        return false;
    }
}
