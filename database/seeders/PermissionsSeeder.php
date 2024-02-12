<?php

namespace Database\Seeders;

use App\Models\Permissions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name'          => 'Appointments & Clients',
                'sub_name'      => 'View the Appointment Book',
                'targets'       => 0,
                'limited'       => 1,
                'standard'      => 1,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Appointments & Clients',
                'sub_name'      => 'Make and change appointments',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Appointments & Clients',
                'sub_name'      => 'Add and edit clients',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Appointments & Clients',
                'sub_name'      => 'Manage the Waitlist',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Appointments & Clients',
                'sub_name'      => 'Use Forms',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Appointments & Clients',
                'sub_name'      => 'View client contact details',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Appointments & Clients',
                'sub_name'      => 'Download client details',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Appointments & Clients',
                'sub_name'      => 'Refund online deposits',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Appointments & Clients',
                'sub_name'      => 'View messages',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Appointments & Clients',
                'sub_name'      => 'Send messages',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Sales',
                'sub_name'      => 'Prepare sales',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Sales',
                'sub_name'      => 'Complete sales',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Sales',
                'sub_name'      => 'Edit prices',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Sales',
                'sub_name'      => 'Apply manual discounts',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Sales',
                'sub_name'      => 'View completed invoices',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Sales',
                'sub_name'      => 'Edit completed invoice (basic)',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Sales',
                'sub_name'      => 'Edit completed invoice (advanced)',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Sales',
                'sub_name'      => 'Delete completed invoice (same-day only)',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Reporting',
                'sub_name'      => 'View own Targets',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Reporting',
                'sub_name'      => 'View own Scoreboard',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Reporting',
                'sub_name'      => 'View business Scoreboard',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Reporting',
                'sub_name'      => 'View Benchmark',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Reporting',
                'sub_name'      => 'Run all reports',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Reporting',
                'sub_name'      => 'View and set Targets',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Staff',
                'sub_name'      => 'View own timetable',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Staff',
                'sub_name'      => 'Add and edit staff timetables',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Staff',
                'sub_name'      => 'Add and edit timetable overrides',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Staff',
                'sub_name'      => 'View own Time Sheets',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Staff',
                'sub_name'      => 'Approve Time Sheets',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Staff',
                'sub_name'      => 'Add and edit Kitomba 1 users',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Marketing',
                'sub_name'      => 'Create Mailchimp campaigns',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Marketing',
                'sub_name'      => 'Create Kmail campaigns',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Marketing',
                'sub_name'      => 'Create Text campaigns',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Administration',
                'sub_name'      => 'Manage Products and Services',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Administration',
                'sub_name'      => 'Set up Time Clock',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Administration',
                'sub_name'      => 'Create and manage Forms',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Administration',
                'sub_name'      => 'Add and manage Reasons',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Administration',
                'sub_name'      => 'Edit and cancel Vouchers',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Administration',
                'sub_name'      => 'Search Vouchers',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Administration',
                'sub_name'      => 'Edit business settings',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Administration',
                'sub_name'      => 'Manage business leave',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Administration',
                'sub_name'      => 'Create Voucher batches',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
            [
                'name'          => 'Administration',
                'sub_name'      => 'Manage rooms and equipment',
                'targets'       => 0,
                'limited'       => 0,
                'standard'      => 0,
                'standardplus'  => 1,
                'advance'       => 1,
                'advanceplus'   => 1,
                'admin'         => 1,
                'account'       => 0
            ],
        ];

        foreach( $permissions as $permission )
        {
            Permissions::create($permission);
        }
    }
}
