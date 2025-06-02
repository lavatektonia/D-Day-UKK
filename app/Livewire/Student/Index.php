<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Student;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Session; 

class Index extends Component
{
    use WithPagination;

    public $search;

    protected $updatesQueryString = ['search'];
    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $students = Student::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('nis', 'like', '%' . $this->search . '%')
                      ->orWhere('address', 'like', '%' . $this->search . '%')
                      ->orWhere('contact', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        // Jika kamu tidak pakai data gender, hapus baris 'genders' di bawah
        $genders = [
            'M' => 'Male',
            'F' => 'Female',
        ];

        $class_groups = [
            'SijaA' => 'SIJA A',
            'SijaB' => 'SIJA B',
        ];

        return view('livewire.student.index', [
            'students' => $students,
            'genders' => $genders,
            'class_groups' => $class_groups,
        ]);
    }

    public function delete($id)
{
    $student = Student::with('pkl')->findOrFail($id);

    // Cek apakah masih terdaftar PKL
    if ($student->pkl) {
        session()->flash('error', 'Student masih terdaftar PKL dan tidak bisa dihapus.');
        return;
    }

    $student->delete();
    session()->flash('success', 'Student berhasil dihapus.');
}

}
