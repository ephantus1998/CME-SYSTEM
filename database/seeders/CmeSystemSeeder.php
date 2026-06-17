namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;
use App\Models\Cme;
use App\Models\Attendance;

class CmeSystemSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Sample Staff Members
        $staffMembers = [
            ['name' => 'John Doe', 'staff_no' => 'MNG001', 'department' => 'Nursing'],
            ['name' => 'Mary Wanjiku', 'staff_no' => 'LAB042', 'department' => 'Laboratory'],
            ['name' => 'Dr. David Owino', 'staff_no' => 'MED102', 'department' => 'Medical'],
            ['name' => 'Sarah Cherop', 'staff_no' => 'PHARM05', 'department' => 'Pharmacy'],
            ['name' => 'Grace Mutua', 'staff_no' => 'ADMIN12', 'department' => 'ICT / Admin'],
        ];

        foreach ($staffMembers as $member) {
            Staff::create($member);
        }

        // 2. Create Sample CME Sessions
        $cme1 = Cme::create([
            'title' => 'Infection Prevention and Control (IPC) Protocols',
            'date' => now()->subDays(2)->format('Y-m-d'),
            'facilitator' => 'Dr. David Owino',
            'location' => 'Main Training Hall',
        ]);

        $cme2 = Cme::create([
            'title' => 'Electronic Medical Records (EMR) System Security Auditing',
            'date' => now()->format('Y-m-d'),
            'facilitator' => 'Grace Mutua',
            'location' => 'ICT Lab',
        ]);

        // 3. Generate Mock Attendance for the first CME
        $allStaff = Staff::all();
        
        // Let's mark some as Present and some as Absent for the first CME
        foreach ($allStaff as $index => $staff) {
            Attendance::create([
                'cme_id' => $cme1->id,
                'staff_id' => $staff->id,
                'status' => $index % 2 === 0 ? 'Present' : 'Absent',
            ]);
        }
    }
}